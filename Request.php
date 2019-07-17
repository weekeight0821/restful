<?php

class Request
{   //允许的请求方式
    const METHODS = array('get', 'post', 'put', 'delet', 'patch');
    //存取的数据
    public $data = array(
        1 => array('name' => '托福班', 'count' => 18),
        2 => array('name' => '雅思班', 'count' => 20),
    );

    /**
     * 处理请求
     */
    public function getRequest()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (in_array($method, self::METHODS)) {
            $func_name = $method.'Data';
            $result = $this->$func_name($_REQUEST);
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * 处理是get的请求
     * GET  http://localhost/restful/class  列出所有班级.
     * GET  http://localhost/restful/class/1    获取指定班的信息.
     */
    public function getData($request_data)
    {
        $class_id = (int)$request_data['class'];
        if ($class_id > 0) {
            $respose_data = $this->data[$class_id];
        } else {
            $respose_data = $this->data;
        }

        return $respose_data;
    }

    /**
     * 处理是post的请求
     * POST http://localhost/restful/class?name=SAT班&count=23 新建一个班.
     */
    public function postData($request_data)
    {
        if (!empty($request_data['name'])) {
            $new_data['name'] = $request_data['name'];
            $new_data['count'] = $request_data['count'];
            $this->data[] = $new_data;
            $respose_data = $this->data;
        } else {
            $respose_data = false;
        }

        return $respose_data;
    }

    /**
     * 处理put的请求(全部更新)
     * PUT  http://localhost/restful/class/1?name=SAT班&count=23  更新指定班的信息（全部信息）
     */
    public function putData($request_data)
    {
        $class_id = (int)$request_data['class'];
        if ($class_id > 0) {
            if (!empty($request_data['name'])) {
                $this->data[$class_id]['name'] = $request_data['name'];
            }
            if (!empty($request_data['count'])) {
                $this->data[$class_id]['count'] = (int)$request_data['count'];  
            }
            $respose_data = $this->data;
        } else {
            $respose_data = false;
        }

        return $respose_data;
    }
    /**
     * 处理patch的请求(部分更新)
     * PATCH  http://localhost/restful/class/1?name=SAT班    更新指定班的信息（部分信息）
     */
    public function patchData($request_data)
    {   
        $class_id = (int)$request_data['class'];
        if ($class_id > 0) {
            if (!empty($request_data['name'])) {
                $this->data[$class_id]['name'] = $request_data['name'];
            }
            if (!empty($request_data['count'])) {
                $this->data[$class_id]['count'] = (int)$request_data['count'];  
            }
            $respose_data = $this->data;
        } else {
            $respose_data = false;
        }
        
        return $respose_data;
    }
    /**
     * 处理delete的请求
     * DELETE  http://localhost/restful/class/1 删除指定班
     */
    public function deleteData($request_data) 
    {
        $class_id = (int)$request_data['class'];
        if ($class_id > 0) {
            unset($this->data[$class_id]);
            $respose_data = $this->data;
        } else {
            $respose_data = false;
        }

        return $respose_data;
    }


}
