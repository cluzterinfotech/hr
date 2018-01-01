<?php 
/*
array(9) {
  ["controllers"] => array(2) 
	{
    ["invokables"] => array(5) 
		{
      ["Album\Controller\Album"] => string(32) "Album\Controller\AlbumController"
      ["Application\Controller\Index"] => string(38) "Application\Controller\IndexController"
      ["proforma"] => string(37) "Coupons\Controller\ProformaController"
      ["user"] => string(30) "User\Controller\UserController"
      ["TestAjax\Controller\Skeleton"] => 
			string(38)
		}
    ["factories"] => array(2) 
		{
      ["Coupons\Controller\Proforma"] => object(Closure)#63 (2) {
        ["this"] => 
			object(Coupons\Module) // 62 (0) {
		}
        ["parameter"] => array(1) 
		{
          ["$sm"] => 
			string(10)
		}
	}
      ["User\Controller\User"] => object(Closure)#75 (2) {
        ["this"] => 
	object(User\Module) // 70 (0) {
}
        ["parameter"] => array(1) 
{
          ["$sm"] => 
	string(10)
}
  ["controller_plugins"] => array(1) 
{
    ["invokables"] => array(2) 
	{
      ["Myplugin"] => string(36) "ZfCommons\Controller\Plugin\Myplugin"
      ["userAuthentication"] => 
		string(41)
	}
}
  ["router"] => array(1) 
{
    ["routes"] => array(6) 
	{
      ["album"] => array(2) 
		{
        ["type"] => string(7) "segment"
        ["options"] => array(3) 
			{
          ["route"] => string(22) "/album[/:action][/:id]"
          ["constraints"] => array(2) 
				{
            ["action"] => string(22) "[a-zA-Z][a-zA-Z0-9_-]*"
            ["id"] => 
					string(6)
				}
          ["defaults"] => array(2) 
				{
            ["controller"] => string(22) "Album\Controller\Album"
            ["action"] => 
					string(5)
				}
			}
		}
      ["home"] => array(2) 
		{
        ["type"] => string(28) "Zend\Mvc\Router\Http\Literal"
        ["options"] => array(2) 
			{
          ["route"] => string(1) "/"
          ["defaults"] => array(2) 
				{
            ["controller"] => string(28) "Application\Controller\Index"
            ["action"] => 
					string(5)
				}
			}
		}
      ["application"] => array(4) 
		{
        ["type"] => string(7) "Literal"
        ["options"] => array(2) 
			{
          ["route"] => string(12) "/application"
          ["defaults"] => array(3) 
				{
            ["__NAMESPACE__"] => string(22) "Application\Controller"
            ["controller"] => string(5) "Index"
            ["action"] => 
					string(5)
				}
			}
        ["may_terminate"] => bool(true)
        ["child_routes"] => array(1) 
			{
          ["default"] => array(2) 
				{
            ["type"] => string(7) "Segment"
            ["options"] => array(3) 
					{
              ["route"] => string(24) "/[:controller[/:action]]"
              ["constraints"] => array(2) 
						{
                ["controller"] => string(22) "[a-zA-Z][a-zA-Z0-9_-]*"
                ["action"] => 
							string(22)
						}
              ["defaults"] => array(0) 
						{
						}
					}
				}
			}
		}
      ["coupons"] => array(2) 
		{
        ["type"] => string(7) "segment"
        ["options"] => array(3) 
			{
          ["route"] => string(25) "/proforma[/:action][/:id]"
          ["constraints"] => array(2) 
				{
            ["action"] => string(22) "[a-zA-Z][a-zA-Z0-9_-]*"
            ["id"] => 
					string(6)
				}
          ["defaults"] => array(2) 
				{
            ["controller"] => string(8) "proforma"
            ["action"] => 
					string(5)
				}
			}
		}
      ["user"] => array(2) 
		{
        ["type"] => string(28) "Zend\Mvc\Router\Http\Literal"
        ["options"] => array(2) 
			{
          ["route"] => string(5) "/user"
          ["defaults"] => array(2) 
				{
            ["controller"] => string(4) "user"
            ["action"] => 
					string(5)
				}
			}
		}
      ["TestAjax"] => array(4) 
		{
        ["type"] => string(7) "Literal"
        ["options"] => array(2) 
			{
          ["route"] => string(9) "/testajax"
          ["defaults"] => array(3) 
				{
            ["__NAMESPACE__"] => string(19) "TestAjax\Controller"
            ["controller"] => string(8) "Skeleton"
            ["action"] => 
					string(5)
				}
			}
        ["may_terminate"] => bool(true)
        ["child_routes"] => array(1) 
			{
          ["default"] => array(2) 
				{
            ["type"] => string(7) "Segment"
            ["options"] => array(3) 
					{
              ["route"] => string(24) "/[:controller[/:action]]"
              ["constraints"] => array(2) 
						{
                ["controller"] => string(22) "[a-zA-Z][a-zA-Z0-9_-]*"
                ["action"] => 
							string(22)
						}
              ["defaults"] => array(0) 
						{
						}
					}
				}
			}
		}
	}
}
  ["view_manager"] => array(6) 
{
    ["template_path_stack"] => array(6) 
	{
      ["album"] => string(70) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\Album\config/../view"
      [0] => string(76) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\Application\config/../view"
      ["coupons"] => string(72) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\Coupons\config/../view"
      ["user"] => string(69) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\User\config/../view"
      ["TestAjax"] => string(73) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\TestAjax\config/../view"
      ["zenddevelopertools"] => 
		string(83)
	}
    ["display_not_found_reason"] => bool(true)
    ["display_exceptions"] => bool(true)
    ["not_found_template"] => string(9) "error/404"
    ["exception_template"] => string(11) "error/index"
    ["template_map"] => array(4) 
	{
      ["layout/layout"] => string(96) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\Application\config/../view/layout/layout.phtml"
      ["application/index/index"] => string(106) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\Application\config/../view/application/index/index.phtml"
      ["error/404"] => string(92) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\Application\config/../view/error/404.phtml"
      ["error/index"] => 
		string(94)
	}
}
  ["service_manager"] => array(1) 
{
    ["factories"] => array(2) 
	{
      ["translator"] => string(45) "Zend\I18n\Translator\TranslatorServiceFactory"
      ["Zend\Db\Adapter\Adapter"] => object(Closure)#51 (2) {
        ["static"] => array(1) 
		{
          ["dbParams"] => array(4) 
			{
            ["database"] => string(10) "couponsNew"
            ["username"] => string(2) "sa"
            ["password"] => string(0) ""
            ["hostname"] => 
				string(21)
			}
		}
        ["parameter"] => array(1) 
		{
          ["$sm"] => 
			string(10)
		}
	}
}
  }
  ["translator"] => array(2) {
    ["locale"] => string(5) "en_US"
    ["translation_file_patterns"] => array(1) {
      [0] => array(3) {
        ["type"] => string(7) "gettext"
        ["base_dir"] => string(80) "C:\Program Files\Zend\Apache2\htdocs\zfTwo\module\Application\config/../language"
        ["pattern"] => string(5) "%s.mo"
      }
    }
  }
  ["service_factory"] => array(1) {
    ["invokables"] => array(1) {
      ["User\Model\TrackTable"] => string(21) "User\Model\TrackTable"
    }
  }
  ["di"] => array(1) {
    ["instance"] => array(5) {
      ["alias"] => array(1) {
        ["user"] => string(30) "User\Controller\UserController"
      }
      ["user"] => array(1) {
        ["parameters"] => array(1) {
          ["broker"] => string(33) "Zend\Mvc\Controller\PluginManager"
        }
      }
      ["User\Event\Authentication"] => array(1) {
        ["parameters"] => array(2) {
          ["userAuthenticationPlugin"] => string(41) "User\Controller\Plugin\UserAuthentication"
          ["aclClass"] => string(12) "User\Acl\Acl"
        }
      }
      ["User\Acl\Acl"] => array(1) {
        ["parameters"] => array(1) {
          ["config"] => array(1) {
            ["acl"] => array(2) {
              ["roles"] => array(2) {
                ["guest"] => NULL
                ["admin"] => string(5) "guest"
              }
              ["resources"] => array(1) {
                ["allow"] => array(4) {
                  ["user"] => array(2) {
                    ["login"] => string(5) "guest"
                    ["all"] => string(5) "admin"
                  }
                  ["Album\Controller\Album"] => array(1) {
                    ["all"] => string(5) "admin"
                  }
                  ["TestAjax\Controller\Skeleton"] => array(1) {
                    ["all"] => string(5) "admin"
                  }
                  ["proforma"] => array(1) {
                    ["all"] => string(5) "admin"
                  }
                }
              }
            }
          }
        }
      }
      ["User\Controller\Plugin\UserAuthentication"] => array(1) {
        ["parameters"] => array(1) {
          ["authAdapter"] => string(35) "Zend\Authentication\Adapter\DbTable"
        }
      }
    }
  }
  ["zenddevelopertools"] => array(2) {
    ["profiler"] => array(6) {
      ["enabled"] => bool(true)
      ["strict"] => bool(false)
      ["flush_early"] => bool(false)
      ["cache_dir"] => string(10) "data/cache"
      ["matcher"] => array(0) {
      }
      ["collectors"] => array(0) {
      }
    }
    ["toolbar"] => array(5) {
      ["enabled"] => bool(true)
      ["auto_hide"] => bool(false)
      ["position"] => string(6) "bottom"
      ["version_check"] => bool(true)
      ["entries"] => array(0) {
      }
    }
  }
}
*/