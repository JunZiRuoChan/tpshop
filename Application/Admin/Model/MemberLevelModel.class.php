<?php
namespace Admin\Model;

use Think\Model;

class MemberLevelModel extends Model{
    protected $patchValidate = true;
    protected $_validate=array(
        array('level_name','require','该字段不能为空',1),
        array('level_rate','number','该字段必须为数字',1),
        array('level_rate',array(1,100),'该字段必须为1-100间的数字',1,'between'),
        array('jifen_bottom','number','该字段必须为数字',1),
        array('jifen_top','number','该字段必须为数字',1)
    );
}
