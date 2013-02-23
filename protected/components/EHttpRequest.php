<?php 
 
class EHttpRequest extends CHttpRequest
{
 
	public function redirect($url,$terminate=true,$statusCode=302) {
		if(is_array($url) && isset($url[0]))
			$url = $url[0];
 
		if(Yii::app()->request->isAjaxRequest){
 
			$data = array();
 
			if(Yii::app()->user->hasFlash('updatedata')) {
				$flashdata = Yii::app()->user->getFlash('updatedata');		
				$data = $data + $flashdata;	
			}
 
			$data['#content']= '<script type="text/javascript">
 
				jQuery.ajax({
					url:"'.$url.'",
					type:"get",
					success:applychanges
				});
 
			</script>';
 
			header('Content-type: text/x-json');
			echo CJSON::encode($data);
 
			Yii::app()->end();	
		} else {
			parent::redirect($url);
		}
	}
 
	public function refresh() {
		if(Yii::app()->request->isAjaxRequest){
 
			$data = array();
 
			if(Yii::app()->user->hasFlash('updatedata')) {
				$flashdata = Yii::app()->user->getFlash('updatedata');		
				$data = $data + $flashdata;	
			}
 
 
			$data['#content']= '<script type="text/javascript">
			var url = $.bbq.getState( "url" );
 
			jQuery.ajax({
					url:url,
					type:"get",
					success:applychanges
				});
 
			</script>';
 
			header('Content-type: text/x-json');
			echo CJSON::encode($data);
 
 
			Yii::app()->end();	
		} else {
			parent::refresh();
		}
	}
}