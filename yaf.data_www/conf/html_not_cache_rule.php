<?php
/*规则为正则匹配,匹配 controller/action
 *无需开启缓存,则增加规则   #.*#
 */
 //return array('#.*#');
return array('#^user#',
             '#^innerletter#',
             '#^money#', 
             '#^activity#',
             '#^mall#', 
             '#^forum#', 
             '#^customer#',
             '#^faq#', 
             '#^site/getnovicePackage#'
            );