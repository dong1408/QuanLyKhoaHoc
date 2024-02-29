<?php

namespace App\ViewModel\BaiBao;

use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\TapChi\TapChiVm;

class BaiBaoKhoaHocVm
{
    private $id;
    private $sanPhamVm;  // $id_sanpham
    private $doi;
    private $url;
    private $received;
    private $accepted;
    private $published;
    private $abstract;
    private $keywords;
    private $tapchiVm; // $id_tapchi
    private $volume;
    private $issue;
    private $number;
    private $page;
    private $created_at;
    private $updated_at;


    function __construct()
    {
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getSanPhamVm()
    {
        return $this->sanPhamVm;
    }

    function setSanPhamVm(SanPhamVm $sanPhamVm)
    {
        $this->sanPhamVm = $sanPhamVm;
    }

    public function getDoi(){
        return $this->doi;
    }

    public function setDoi($doi){
        $this->doi = $doi;
    }

    public function getUrl(){
        return $this->url;
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function getReceived(){
        return $this->received;
    }

    public function setReceived($received){
        $this->received = $received;
    }

    public function getAccepted(){
        return $this->accepted;
    }

    public function setAccepted($accepted){
        $this->accepted = $accepted;
    }

    public function getPublished(){
        return $this->published;
    }

    public function setPublished($published){
        $this->published = $published;
    }

    public function getAbstract(){
        return $this->abstract;
    }

    public function setAbstract($abstract){
        $this->abstract = $abstract;
    }

    public function getKeywords(){
        return $this->keywords;
    }

    public function setKeywords($keywords){
        $this->keywords = $keywords;
    }

    public function getTapChiVm(){
        return $this->tapchiVm;
    }

    public function setTapChiVm(TapChiVm $tapChiVm){
        $this->tapchiVm = $tapChiVm;
    }

    public function getVolume(){
        return $this->volume;
    }

    public function setVolume($volume){
        $this->volume = $volume;
    }

    public function getIssue(){
        return $this->issue;
    }

    public function setIssue($issue){
        $this->issue = $issue;
    }

    public function getNumber(){
        return $this->number;
    }

    public function setNumber($number){
        $this->number = $number;
    }

    public function getPage(){
        return $this->page;
    }

    public function setPage($page){
        $this->page = $page;
    }

    function getCreatedAt()
    {
        return $this->created_at;
    }

    function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt()
    {
        return $this->updated_at;
    }

    function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
