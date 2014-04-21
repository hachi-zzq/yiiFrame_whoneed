<?php
/**
 * pdc_channel转移到pdcc_channel及pdcc_sub_channel
 */
class Channel_to_new_tableCommand extends CConsoleCommand
{
    //get all app info or update app info
    public function actionIndex(){
        //转移父channel
        echo 'father channel begin'.PHP_EOL;
        $channel_fobjs = Pdc_channel::model()->findAll('fid = 0');
        if($channel_fobjs){
            foreach($channel_fobjs as $fobj){
                $new_channel_obj = new Pdcc_channel;
                $new_channel_obj->id                  =$fobj->id;
                $new_channel_obj->product_id          =1;
                $new_channel_obj->channel_name        =$fobj->channel_name;
                $new_channel_obj->channel_type        =$fobj->channel_type;
                $new_channel_obj->channel_from        =$fobj->channel_from;
                $new_channel_obj->channel_child_param =$fobj->channel_child_param;
                $new_channel_obj->is_cooperation      =$fobj->is_cooperation;
                $new_channel_obj->create_time         =$fobj->create_time;
                $new_channel_obj->is_redirect         =$fobj->is_redirect;
                $new_channel_obj->view_name           =$fobj->view_name;
                $new_channel_obj->save();
            }
        }

        //转移子channel
        echo 'son channel begin'.PHP_EOL;
        $sub_objs = Pdc_channel::model()->findAll('fid != 0');
        if($sub_objs){
            foreach($sub_objs as $sub_obj){
                $new_sub_obj = new Pdcc_sub_channel;
                $new_sub_obj->channel_id          =$sub_obj->fid;
                $new_sub_obj->sub_id              =$sub_obj->id;
                $new_sub_obj->sub_channel_name    =$sub_obj->channel_name;
                $new_sub_obj->save();
            }
        }
        echo 'end!'.PHP_EOL;
    }
}