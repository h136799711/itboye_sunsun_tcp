<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * User: hebidu<346551990@qq.com>
 * Date: 2017-10-19 11:25
 * Copyright: ${year} www.itboye.com Boye Inc. All rights reserved.
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-10-19 11:25
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

namespace sunsun\transfer_station\client\interfaces;


class SetDataRef implements SetDataInterface
{

    public function convertUnderline($str)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $str;
    }

    public function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }

    public function setData($data = null)
    {
        if (!empty($data) && is_array($data)) {
            $className = get_class($this);
            $ref = new \ReflectionClass($className);
            $properties = $ref->getProperties();
            foreach ($properties as $obj) {
                $name = $obj->name;
                $key = $this->uncamelize($name);
                $methodName = 'set' . ucfirst($name);
                if (array_key_exists($key, $data) && $ref->hasMethod($methodName)) {
                    $this->$methodName($data[$key]);
                }
            }
        }
    }

}