<?php
namespace Admin\Model;
use Think\Model;
class ExtendModel extends Model{
    protected $_map = array(
        // 'id'    =>'id',
        'title' =>'extend_title',
        'url'   =>'extend_url',
        'num'   =>'extend_num',
        'content'  =>'extend_content',
        'success'   =>'extend_success_num',
        'fail'  =>'extend_fail_num',
    );
}
