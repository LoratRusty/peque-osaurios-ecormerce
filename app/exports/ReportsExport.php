<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReportsExport
{
    protected $data;
    protected $titulo;
    protected $fechaInicio;
    protected $fechaFin;
    protected $includeCharts;
    protected $chartConfig;

    public function __construct(Collection $data, string $titulo, string $fechaInicio, string $fechaFin, bool $includeCharts = true, array $chartConfig = [])
    {
        $this->data = $data;
        $this->titulo = $titulo;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->includeCharts = $includeCharts;
        $this->chartConfig = array_merge([
            'type' => 'column', // column, bar, line, pie
            'width' => 12,
            'height' => 8,
            'position' => 'right', // right, bottom
        ], $chartConfig);
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Configurar título de la hoja
        $sheet->setTitle('Reporte');
        
        // Configurar información del encabezado
        $sheet->setCellValue('A1', $this->titulo);
        $sheet->setCellValue('A2', 'Período: ' . Carbon::parse($this->fechaInicio)->format('d/m/Y') . ' - ' . Carbon::parse($this->fechaFin)->format('d/m/Y'));
        $sheet->setCellValue('A3', 'Generado: ' . now()->format('d/m/Y H:i:s'));
        
        // Verificar si hay usuario autenticado
        if (auth()->check()) {
            $sheet->setCellValue('A4', 'Usuario: ' . auth()->user()->name);
        } else {
            $sheet->setCellValue('A4', 'Usuario: Sistema');
        }

        // Aplicar estilos al título
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => 'EC4899'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
        ]);

        // Aplicar estilos a la información
        $sheet->getStyle('A2:A4')->applyFromArray([
            'font' => [
                'size' => 10,
                'color' => ['rgb' => '666666'],
            ],
        ]);

        // Si no hay datos, retornar solo con encabezados
        if ($this->data->isEmpty()) {
            $sheet->setCellValue('A6', 'No hay datos para mostrar en el período seleccionado');
            $sheet->getStyle('A6')->applyFromArray([
                'font' => [
                    'italic' => true,
                    'color' => ['rgb' => '999999'],
                ],
            ]);
            return $this->generateFile($spreadsheet);
        }

        // Obtener encabezados de los datos
        $firstItem = $this->data->first();
        
        // Verificar que el primer elemento sea un array
        if (!is_array($firstItem)) {
            throw new \Exception('Los datos deben ser arrays asociativos');
        }
        
        $headers = array_keys($firstItem);
        
        // Escribir encabezados en la fila 6
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '6', $header);
            $column++;
        }

        // Aplicar estilo a los encabezados
        $lastColumn = $this->getColumnLetter(count($headers) - 1);
        $sheet->getStyle('A6:' . $lastColumn . '6')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'EC4899'], // Rosa
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Escribir datos comenzando desde la fila 7
        $row = 7;
        foreach ($this->data as $item) {
            $column = 'A';
            foreach ($item as $value) {
                // Manejar valores nulos
                $cellValue = $value ?? '';
                $sheet->setCellValue($column . $row, $cellValue);
                $column++;
            }
            $row++;
        }

        // Aplicar bordes y alineación a los datos
        $dataRange = 'A7:' . $lastColumn . ($row - 1);
        if ($row > 7) { // Solo si hay datos
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Alternar colores de filas
            for ($i = 7; $i < $row; $i++) {
                if (($i - 7) % 2 == 1) { // Filas impares
                    $sheet->getStyle('A' . $i . ':' . $lastColumn . $i)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FCE7F3'], // Rosa muy claro
                        ],
                    ]);
                }
            }
        }

        // Auto-ajustar columnas
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Ajustar altura de filas
        for ($i = 1; $i < $row; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(20);
        }

        // Altura especial para el encabezado de datos
        $sheet->getRowDimension(6)->setRowHeight(25);

        // Agregar totales si es un reporte de ventas
        $totalsRow = $row;
        if (strpos($this->titulo, 'Ventas') !== false) {
            $totalsRow = $this->addSalesTotals($sheet, $row, $lastColumn);
        }

        // Agregar gráficos si está habilitado
        if ($this->includeCharts && $row > 7) {
            $this->addCharts($sheet, $totalsRow, $lastColumn, $headers);
        }

        return $this->generateFile($spreadsheet);
    }

    protected function addSalesTotals($sheet, $currentRow, $lastColumn)
    {
        $totalRow = $currentRow + 1;
        $sheet->setCellValue('A' . $totalRow, 'TOTALES:');
        
        // Verificar si existe la columna 'Total Ventas'
        $firstItem = $this->data->first();
        if (isset($firstItem['Total Ventas'])) {
            $totalVentas = $this->data->sum(function($item) {
                $valor = str_replace(['$', ','], '', $item['Total Ventas']);
                return (float) $valor;
            });
            
            $sheet->setCellValue('B' . $totalRow, '$' . number_format($totalVentas, 2));
            
            if (isset($firstItem['Cantidad Órdenes'])) {
                $totalOrdenes = $this->data->sum('Cantidad Órdenes');
                $sheet->setCellValue('C' . $totalRow, $totalOrdenes);
            }
            
            // Aplicar estilo a los totales
            $sheet->getStyle('A' . $totalRow . ':C' . $totalRow)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3E8FF'],
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => Border::BORDER_MEDIUM,
                        'color' => ['rgb' => 'EC4899'],
                    ],
                ],
            ]);
        }
        
        return $totalRow + 1;
    }

    protected function addCharts($sheet, $startRow, $lastColumn, $headers)
    {
        // Detectar columnas numéricas para gráficos
        $numericColumns = $this->detectNumericColumns($headers);
        
        if (empty($numericColumns)) {
            return; // No hay datos numéricos para graficar
        }

        // Determinar posición del gráfico
        if ($this->chartConfig['position'] === 'right') {
            $chartStartColumn = $this->getColumnLetter(count($headers) + 2);
            $chartStartRow = 6;
        } else {
            $chartStartColumn = 'A';
            $chartStartRow = $startRow + 2;
        }

        // Crear gráfico principal
        $this->createMainChart($sheet, $chartStartColumn, $chartStartRow, $numericColumns, $headers);

        // Si hay suficientes datos, crear gráfico de tendencias
        if ($this->data->count() > 5 && $this->hasDateColumn($headers)) {
            $trendChartRow = $chartStartRow + $this->chartConfig['height'] + 2;
            $this->createTrendChart($sheet, $chartStartColumn, $trendChartRow, $numericColumns, $headers);
        }
    }

    protected function createMainChart($sheet, $startColumn, $startRow, $numericColumns, $headers)
    {
        // Configurar etiquetas (primera columna o columna de fechas)
        $labelColumn = 'A';
        $dataStartRow = 7;
        $dataEndRow = 6 + $this->data->count();

        $labels = [
            new DataSeriesValues('String', 'Reporte!' . $labelColumn . $dataStartRow . ':' . $labelColumn . $dataEndRow),
        ];

        // Configurar series de datos
        $seriesData = [];
        $seriesLabels = [];

        foreach ($numericColumns as $columnIndex => $columnName) {
            $columnLetter = $this->getColumnLetter($columnIndex);
            
            $seriesLabels[] = new DataSeriesValues('String', 'Reporte!' . $columnLetter . '6:' . $columnLetter . '6');
            $seriesData[] = new DataSeriesValues('Number', 'Reporte!' . $columnLetter . $dataStartRow . ':' . $columnLetter . $dataEndRow);
        }

        // Crear serie de datos
        $series = new DataSeries(
            $this->getChartType(),
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($seriesData) - 1),
            $seriesLabels,
            $labels,
            $seriesData
        );

        // Configurar área de ploteo
        $plotArea = new PlotArea(null, [$series]);
        
        // Configurar leyenda
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        
        // Configurar título
        $title = new Title('Gráfico - ' . $this->titulo);
        
        // Crear gráfico
        $chart = new Chart(
            'chart1',
            $title,
            $legend,
            $plotArea,
            true,
            DataSeries::EMPTY_AS_GAP,
            null,
            null
        );

        // Posicionar gráfico
        $endColumn = $this->getColumnLetter($this->getColumnIndex($startColumn) + $this->chartConfig['width']);
        $endRow = $startRow + $this->chartConfig['height'];
        
        $chart->setTopLeftPosition($startColumn . $startRow);
        $chart->setBottomRightPosition($endColumn . $endRow);

        // Agregar gráfico a la hoja
        $sheet->addChart($chart);
    }

    protected function createTrendChart($sheet, $startColumn, $startRow, $numericColumns, $headers)
    {
        // Solo crear si hay columna de fecha
        $dateColumnIndex = $this->getDateColumnIndex($headers);
        if ($dateColumnIndex === null) return;

        $dataStartRow = 7;
        $dataEndRow = 6 + $this->data->count();

        // Usar fechas como etiquetas
        $dateColumn = $this->getColumnLetter($dateColumnIndex);
        $labels = [
            new DataSeriesValues('String', 'Reporte!' . $dateColumn . $dataStartRow . ':' . $dateColumn . $dataEndRow),
        ];

        // Configurar series para tendencias (solo la primera columna numérica)
        $firstNumericColumn = array_keys($numericColumns)[0];
        $columnLetter = $this->getColumnLetter($firstNumericColumn);
        
        $seriesLabels = [new DataSeriesValues('String', 'Reporte!' . $columnLetter . '6:' . $columnLetter . '6')];
        $seriesData = [new DataSeriesValues('Number', 'Reporte!' . $columnLetter . $dataStartRow . ':' . $columnLetter . $dataEndRow)];

        // Crear serie de líneas
        $series = new DataSeries(
            DataSeries::TYPE_LINECHART,
            DataSeries::GROUPING_STANDARD,
            [0],
            $seriesLabels,
            $labels,
            $seriesData
        );

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $title = new Title('Tendencia - ' . $numericColumns[$firstNumericColumn]);
        
        $chart = new Chart(
            'chart2',
            $title,
            $legend,
            $plotArea,
            true,
            DataSeries::EMPTY_AS_GAP,
            null,
            null
        );

        // Posicionar gráfico de tendencia
        $endColumn = $this->getColumnLetter($this->getColumnIndex($startColumn) + $this->chartConfig['width']);
        $endRow = $startRow + $this->chartConfig['height'];
        
        $chart->setTopLeftPosition($startColumn . $startRow);
        $chart->setBottomRightPosition($endColumn . $endRow);

        $sheet->addChart($chart);
    }

    protected function detectNumericColumns($headers)
    {
        $numericColumns = [];
        $firstItem = $this->data->first();
        
        foreach ($headers as $index => $header) {
            $value = $firstItem[$header];
            
            // Detectar si es numérico (incluyendo formatos de moneda)
            if (is_numeric($value) || $this->isMoneyFormat($value)) {
                $numericColumns[$index] = $header;
            }
        }
        
        return $numericColumns;
    }

    protected function isMoneyFormat($value)
    {
        if (!is_string($value)) return false;
        
        // Remover símbolos de moneda y comas
        $cleaned = str_replace(['$', ',', '€', '£'], '', $value);
        return is_numeric($cleaned);
    }

    protected function hasDateColumn($headers)
    {
        foreach ($headers as $header) {
            if (strpos(strtolower($header), 'fecha') !== false || 
                strpos(strtolower($header), 'date') !== false) {
                return true;
            }
        }
        return false;
    }

    protected function getDateColumnIndex($headers)
    {
        foreach ($headers as $index => $header) {
            if (strpos(strtolower($header), 'fecha') !== false || 
                strpos(strtolower($header), 'date') !== false) {
                return $index;
            }
        }
        return null;
    }

    protected function getChartType()
    {
        switch ($this->chartConfig['type']) {
            case 'bar':
                return DataSeries::TYPE_BARCHART;
            case 'line':
                return DataSeries::TYPE_LINECHART;
            case 'pie':
                return DataSeries::TYPE_PIECHART;
            case 'column':
            default:
                return DataSeries::TYPE_BARCHART;
        }
    }

    protected function getColumnIndex($columnLetter)
    {
        $index = 0;
        $length = strlen($columnLetter);
        
        for ($i = 0; $i < $length; $i++) {
            $index = $index * 26 + (ord($columnLetter[$i]) - ord('A') + 1);
        }
        
        return $index - 1;
    }

    protected function generateFile($spreadsheet)
    {
        $writer = new Xlsx($spreadsheet);
        
        // Habilitar gráficos en el writer
        $writer->setIncludeCharts(true);
        
        // Crear archivo temporal
        $fileName = 'reporte_' . date('Y-m-d_H-i-s') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        
        $writer->save($tempFile);
        
        return $tempFile;
    }

    // Método para obtener la letra de columna
    private function getColumnLetter($index)
    {
        $letter = '';
        while ($index >= 0) {
            $letter = chr($index % 26 + ord('A')) . $letter;
            $index = intval($index / 26) - 1;
        }
        return $letter;
    }

    // Método para descargar directamente
    public function download($filename = null)
    {
        $tempFile = $this->export();
        $filename = $filename ?: 'reporte_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    // Método para guardar en storage
    public function store($path)
    {
        $tempFile = $this->export();
        $content = file_get_contents($tempFile);
        unlink($tempFile);

        return Storage::disk('public')->put($path, $content);
    }

    // Métodos de configuración para gráficos
    public function withCharts(bool $include = true)
    {
        $this->includeCharts = $include;
        return $this;
    }

    public function setChartConfig(array $config)
    {
        $this->chartConfig = array_merge($this->chartConfig, $config);
        return $this;
    }

    public function setChartType(string $type)
    {
        $this->chartConfig['type'] = $type;
        return $this;
    }

    public function setChartPosition(string $position)
    {
        $this->chartConfig['position'] = $position;
        return $this;
    }
}