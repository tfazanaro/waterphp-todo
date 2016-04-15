<?php namespace core\contracts;

interface ICrud
{
    function insert($data);

    function update($id, $data);

    function delete($id);

    function find($id);

    function where($args);

    function all();

    function query($sql);
}