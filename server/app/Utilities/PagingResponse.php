<?php

namespace App\Utilities;

class PagingResponse
{
    public int $totalPage;
    public int $totalRecord;
    public $data;

    public function __construct(int $totalPage, int $totalRecord, $data)
    {
        $this->totalPage = $totalPage;
        $this->totalRecord = $totalRecord;
        $this->data = $data;
    }

    public function getTotalPage()
    {
        return $this->totalPage;
    }

    public function setTotalPage(int $totalPage)
    {
        $this->totalPage = $totalPage;
    }

    public function getTotalRecord()
    {
        return $this->totalRecord;
    }

    public function setTotalRecord(int $totalRecord)
    {
        $this->totalRecord = $totalRecord;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}
