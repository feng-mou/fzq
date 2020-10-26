<?php
    namespace app\api\controller;

    use app\BaseController;

    class AuthBase extends MagBase{
        public $UserId = "";
        public $UserName = "";
        public $accessToken = "";
        public function initialize()
        {
            parent::initialize(); // TODO: Change the autogenerated stub
            $this->accessToken = $this->request->header('access-token');
            //return $this->isLogin();
            if(!$this->accessToken || !$this->isLogin()){
                return $this->show(config('status.not_login'),"未登录");
            }
            //$this->isLogin($this-accessToken);
        }

        /**
         * 判断用户是否登录
         * @token token值
         * @return bool
         */
        public function isLogin()
        {
            $userInfo = cache(config('redis_name.login_token').$this->accessToken);

            if(empty($userInfo)){
                return false;
            }
            //json字符串转数组
            $userInfos = json_decode($userInfo,true);
            //个人信息用来查的信息
            if(!empty($userInfos['id']) && !empty($userInfos['username'])){
                $this->UserId = $userInfos['id'];
                $this->UserName = $userInfos['username'];
                return true;
            }
            return false;
        }
    }