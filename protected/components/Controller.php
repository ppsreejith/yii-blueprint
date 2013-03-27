<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function ajaxRender($file, $data=array()) {
 
		$data['title'] = CHtml::encode($this->pageTitle);			
		header('Content-type: text/x-json');
		echo CJSON::encode($data);
		Yii::app()->end();
 
	}
 
	public function render($file, $params = array(), $data=array()) {
	
		$compactor = Yii::app()->contentCompactor;
		$options = array(
			);
		
		if($compactor == null)
			throw new CHttpException(500, Yii::t('messages', 'Missing component ContentCompactor in configuration.'));
 
		if(Yii::app()->request->isAjaxRequest){
 
			if(Yii::app()->user->hasFlash('updatedata')) {
				$flashdata = Yii::app()->user->getFlash('updatedata');		
				$data = $data + $flashdata;	
			}

			$data['#content'] = $compactor->compact(parent::renderPartial($file, $params, true), $options);
			$data['title'] = CHtml::encode($this->pageTitle);
 
			header('Content-type: text/x-json');
			echo CJSON::encode($data);
			Yii::app()->end();
 
		} else {			
			echo $compactor->compact(parent::render($file, $params, true), $options);
		}	
 
	}
 
	public function redirect($url) {
 
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