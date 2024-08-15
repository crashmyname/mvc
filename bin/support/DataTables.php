<?php
namespace Support;

class DataTables
{
    public static function of(array $data)
    {
        return new static($data);
    }

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function make(bool $jsonEncode = false)
    {
        // Mendapatkan parameter dari request
        $draw = isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 1;
        $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
        $length = isset($_REQUEST['length']) ? intval($_REQUEST['length']) : 10;
        $searchValue = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
        $orderColumnIndex = isset($_REQUEST['order'][0]['column']) ? intval($_REQUEST['order'][0]['column']) : 0;
        $orderDir = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir'] : 'asc';

        // Kolom yang tersedia untuk pengurutan
        $orderColumns = ['user_id', 'username', 'uuid', 'email', 'password'];
        $orderColumn = $orderColumns[$orderColumnIndex] ?? 'user_id';

        // Filter data berdasarkan pencarian
        $filteredData = array_filter($this->data, function ($item) use ($searchValue) {
            foreach ($item as $value) {
                if (stripos($value, $searchValue) !== false) {
                    return true;
                }
            }
            return false;
        });

        // Pengurutan data
        usort($filteredData, function ($a, $b) use ($orderColumn, $orderDir) {
            if ($orderDir === 'asc') {
                return $a[$orderColumn] <=> $b[$orderColumn];
            } else {
                return $b[$orderColumn] <=> $a[$orderColumn];
            }
        });

        // Pagination
        $totalRecords = count($this->data);
        $totalFiltered = count($filteredData);
        $filteredData = array_slice($filteredData, $start, $length);

        // Menyiapkan data untuk respons DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $filteredData
        ];

        if ($jsonEncode) {
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            return $response;
        }
    }
}
?>
