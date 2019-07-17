<?php
class Response 
{
    const HTTP_VESION = 'HTTP/1.1';
    /**
     * 返回客户端请求结果
     *  */
    public static function sendResponse($data)
    {
        if ($data) {
            $code = 200;
            $message = 'OK';
        } else {
            $code = 404;
            $data = array('error'=>'Not Found');
            $message = 'Not Found';
        }
        //设置返回的头信息
        header(self::HTTP_VESION . " " . $code . " " . $message);
        //获取客户端需要返回的数据类型
        $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : $_SERVER['HTTP_ACCEPT'];
        //返回json,xml,html格式
        if (strpos($content_type, 'application/json') !== false) {
            header('Content_Type: application/json');
            echo self::encodeJson($data);
        } else if (strpos($content_type, 'application/xml') !== false) {
            header('Content_Type: application/json');
            echo self::encodeXml($data);
        } else {
            header('Content_Type: text/html');
            echo self::encodeHtml($data);
        }
    }

    /**
     * 返回json格式
     */
    public static function encodeJson($responseData)
    {
        return json_encode($responseData);
    }

    /**
     * 返回xml格式
     */
    public static function encodeXml($responseData)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><rest></rest>');
        foreach ($responseData as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $xml->addChild($k,$v);
                }
            } else {
                $xml->addChild($key, $value);
            }
        }
        return $xml->asXML();
    }
    /**
     * 返回Html格式
     */
    public static function encodeHtml($responseData)
    {
        $html = "<table border='1'>";
        foreach ($responseData as $key => $value) {
            $html .= "<tr>";
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $html .= "<td>" . $k . "</td><td>" . $v . "<td>";
                }
            } else {
                $html .= "<td>" . $key . "</td><td>" . $value . "<td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }
}