<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Size;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentType;
use App\Models\Payment;
use App\Models\Review;

class ClienteTiendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'sizes'])
            ->where('status', true);

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtrar por categoría
        if ($request->filled('category')) {
            $query->where('categoria_id', $request->input('category'));
        }

        // Filtrar por precio mínimo
        if ($request->filled('price_min')) {
            $query->where('precio', '>=', $request->input('price_min'));
        }

        // Filtrar por precio máximo
        if ($request->filled('price_max')) {
            $query->where('precio', '<=', $request->input('price_max'));
        }

        // Ordenar
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'price_asc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('precio', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('nombre', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('nombre', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
            }
        } else {
            // Orden por defecto
            $query->orderBy('id', 'desc');
        }
        // Obtener los filtros aplicados
        $filtros = $request->only(['search', 'category', 'price_min', 'price_max', 'sort']);

        $productos = $query->get();

        $categoria = Categoria::all();
        $size = Size::all();
        
        $user = auth()->user();

        $cartCount = 0;
        if ($user) {
            // Obtener carrito pendiente
            $cart = Cart::where('user_id', $user->id)
                        ->where('status', 'pendiente')
                        ->first();

            if ($cart) {
                // Sumar la cantidad total de todos los items
                $cartCount = $cart->items()->sum('cantidad');
            }
        }

        return view('cliente.store', compact('productos', 'categoria', 'size', 'filtros', 'cartCount'));
    }

    public function product($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);

        // Pasar el producto a la vista
        return view('cliente.product', compact('producto'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'size_id'    => 'required|integer|exists:sizes,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para agregar al carrito.');
        }

        // Buscar el producto y la talla, para verificar stock
        $product = Producto::with('sizes')->findOrFail($request->product_id);

        // Verificar que la talla pertenezca al producto
        $sizeId = $request->size_id;
        $sizePivot = $product->sizes->firstWhere('id', $sizeId);
        if (!$sizePivot) {
            return redirect()->back()->with('error', 'Talla no válida para este producto.');
        }

        // Stock disponible de la talla
        $stockDisponible = $sizePivot->pivot->stock;
        if ($stockDisponible <= 0) {
            return redirect()->back()->with('error', 'Esta talla está agotada.');
        }
        // Cantidad solicitada
        $cantidadSolicitada = $request->quantity;
        if ($cantidadSolicitada > $stockDisponible) {
            return redirect()->back()->with('error', "La cantidad solicitada ({$cantidadSolicitada}) excede el stock disponible ({$stockDisponible}) para la talla seleccionada.");
        }

        // Buscar o crear carrito pendiente
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'pendiente'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Buscar si ya existe este producto+talla en el carrito
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('size_id', $sizeId)
            ->first();

        if ($cartItem) {
            // Si ya existe, sumar cantidad, pero sin exceder stockDisponible
            $nuevaCantidad = $cartItem->cantidad + $cantidadSolicitada;
            if ($nuevaCantidad > $stockDisponible) {
                return redirect()->back()->with('error', "No puedes agregar {$cantidadSolicitada}. Actualmente tienes {$cartItem->cantidad} en carrito, y el stock disponible es {$stockDisponible}.");
            }
            $cartItem->cantidad = $nuevaCantidad;
            $cartItem->precio_unitario = $product->precio;
            $cartItem->save();
        } else {
            // Crear nuevo item en carrito con talla
            CartItem::create([
                'cart_id'        => $cart->id,
                'product_id'     => $product->id,
                'size_id'        => $sizeId,
                'cantidad'       => $cantidadSolicitada,
                'precio_unitario'=> $product->precio,
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito correctamente.');
    }

    public function cart()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'pendiente'],
            ['user_id' => $user->id, 'status' => 'pendiente']
        );

        $cartItems = $cart->items()->with(['product', 'size'])->get();

        $total = $cartItems->sum(fn($item) => $item->cantidad * $item->precio_unitario);

        return view('cliente.cart', compact('cart', 'cartItems', 'total'));
    }

    public function checkout()
    {
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)
            ->where('status', 'pendiente')
            // Cargamos product y size en cada item
            ->with(['items.product', 'items.size'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cliente.store')->with('error', 'Tu carrito está vacío.');
        }

        $total = $cart->items->sum(function ($item) {
            return $item->cantidad * $item->precio_unitario;
        });

        // Traer todos los métodos de pago disponibles
        $paymentTypes = PaymentType::all();

        return view('cliente.checkout', compact('cart', 'total', 'paymentTypes'));
    }

    public function placeOrder(Request $request)
    {
        $user = auth()->user();

        //Validación básica de campos comunes
        $request->validate([
            'direccion'   => 'required|string|max:255',
            'metodo_pago' => 'required|exists:payment_types,id',
            'referencia'  => 'nullable|string|max:100',
        ]);

        //Obtener el carrito pendiente con items (cargamos product y size)
        $cart = Cart::where('user_id', $user->id)
            ->where('status', 'pendiente')
            ->with(['items.product', 'items.size'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cliente.store')->with('error', 'Tu carrito está vacío.');
        }

        //Obtener el PaymentType para saber qué método se eligió
        $paymentType = PaymentType::find($request->input('metodo_pago'));
        $nombreMetodo = $paymentType?->nombre ?? '';

        //Validación condicional de campos extra según método (igual que antes)...
        $rulesExtra = [];
        if (stripos($nombreMetodo, 'tarjeta') !== false) {
            $rulesExtra['card_number']  = ['required', 'string', 'regex:/^[0-9 ]{12,19}$/'];
            $rulesExtra['expiry_month'] = ['required', 'digits:2', 'integer', 'min:1', 'max:12'];
            $currentYear2d = (int) date('y');
            $rulesExtra['expiry_year']  = ['required', 'digits:2', 'integer', 'min:'.$currentYear2d];
            $rulesExtra['cvv']          = ['required', 'digits_between:3,4'];
        } elseif (stripos($nombreMetodo, 'paypal') !== false) {
            $rulesExtra['paypal_email'] = ['required', 'email'];
        } elseif (stripos($nombreMetodo, 'transferencia') !== false) {
            $rulesExtra['referencia']   = ['required', 'string', 'max:100'];
        }
        if (!empty($rulesExtra)) {
            $request->validate($rulesExtra);
        }

        //Comenzar transacción
        DB::beginTransaction();
        try {
            // Calcular total
            $total = $cart->items->sum(fn($item) => $item->cantidad * $item->precio_unitario);

            // Preparar datos de Payment (igual que antes)
            $paymentData = [
                'user_id'         => $user->id,
                'payment_type_id' => $request->metodo_pago,
                'monto'           => $total,
                'estado'          => 'pendiente',
                'referencia'      => null,
            ];
            // Simulación de pago según método...
            if (stripos($nombreMetodo, 'tarjeta') !== false) {
                $paymentData['estado']    = 'completado';
                $paymentData['referencia'] = 'TARJ-' . strtoupper(substr(md5(uniqid()), 0, 10));
            }
            elseif (stripos($nombreMetodo, 'paypal') !== false) {
                $paymentData['estado']    = 'completado';
                $paymentData['referencia'] = 'PP-' . strtoupper(substr(md5(uniqid()), 0, 10));
            }
            elseif (stripos($nombreMetodo, 'transferencia') !== false) {
                $paymentData['estado']    = 'pendiente';
                $paymentData['referencia'] = $request->input('referencia');
            }
            elseif (stripos($nombreMetodo, 'efectivo') !== false) {
                $paymentData['estado']    = 'pendiente';
            } else {
                $paymentData['estado'] = 'pendiente';
                if ($request->filled('referencia')) {
                    $paymentData['referencia'] = $request->input('referencia');
                }
            }

            // Crear Payment
            $payment = Payment::create($paymentData);

            // Crear Order asociado
            $orderStatus = $paymentData['estado'] === 'completado' ? 'procesado' : 'pendiente';
            $order = Order::create([
                'user_id'         => $user->id,
                'total'           => $total,
                'status'          => $orderStatus,
                'direccion_envio' => $request->direccion,
                'metodo_pago'     => $request->metodo_pago,
                'pago_id'         => $payment->id,
            ]);

            //Crear cada OrderItem incluyendo size_id
            foreach ($cart->items as $item) {
                // Verificar si hay stock suficiente en la tabla pivote
                $stockDisponible = DB::table('product_size')
                    ->where('product_id', $item->product_id)
                    ->where('size_id', $item->size_id)
                    ->value('stock');

                if ($stockDisponible < $item->cantidad) {
                    throw new \Exception('Stock insuficiente para el producto "' 
                        . ($item->product->nombre ?? 'desconocido') 
                        . '" en talla "' 
                        . ($item->size->nombre ?? 'N/A') 
                        . '". Stock disponible: ' 
                        . $stockDisponible);
                }

                // Crear OrderItem si hay suficiente stock
                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item->product_id,
                    'size_id'         => $item->size_id,
                    'cantidad'        => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                ]);

                // Descontar stock
                DB::table('product_size')
                    ->where('product_id', $item->product_id)
                    ->where('size_id', $item->size_id)
                    ->decrement('stock', $item->cantidad);
            }


            //Actualizar carrito y limpiar items
            $cart->update(['status' => 'pagado']);
            $cart->items()->delete();

            DB::commit();

            // 12. Redirigir con mensaje según estado de pago
            if ($paymentData['estado'] === 'completado') {
                return redirect()->route('cliente.store')
                    ->with('success', 'Pedido y pago procesados con éxito. Referencia: ' . $paymentData['referencia']);
            } else {
                return redirect()->route('cliente.store')
                    ->with('success', 'Pedido registrado. Esperando confirmación de pago. Referencia proporcionada: ' . ($paymentData['referencia'] ?? 'N/A'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function removeFromCart(Request $request, int $itemId)
    {
        $userId = auth()->id();

        // Buscar el item por id con su carrito
        $cartItem = CartItem::with('cart')->find($itemId);

        if (!$cartItem || $cartItem->cart->user_id !== $userId) {
            return redirect()->back()->withErrors([
                'error' => 'Producto no encontrado en tu carrito o ya ha sido eliminado.'
            ]);
        }

        $cartItem->delete();

        return redirect()->back()->with('success', "Tu producto fue eliminado del carrito.");
    }



    public function createReviewForm()
    {
        $productos = Producto::all();
        return view('cliente.reviews', compact('productos'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'comentario' => 'required|string|max:1000',
            'producto_id' => 'required|exists:products,id',
            'puntuacion' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'nombre' => $request->nombre,
            'comentario' => $request->comentario,
            'producto_id' => $request->producto_id,
            'puntuacion' => $request->puntuacion,
        ]);

        return redirect()->route('cliente.reviews')->with('success', 'Gracias por tu reseña.');
    }

}
