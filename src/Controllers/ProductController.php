<?php
public function get($id): string 
{
    $model = new Product();
    $data = $model->loadData();
    if ($id)
        $data = $data[$id];
    return ProductTemplate::getTemplate($data);
}
?>