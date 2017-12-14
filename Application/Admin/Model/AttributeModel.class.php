<?php

namespace Admin\Model;

use Think\Model;

class AttributeModel extends Model
{
    protected $patchValidate = true;
    protected $_validate = array(
        array('attr_name', 'require', '属性名必须填写'),
        array('type_id', '0', '类型名必须选择', 1, 'notequal'),
    );
}