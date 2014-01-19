<?php
/**
 * @author  luwenbin
 */
class HelpController extends Controller
{
    public $currentPage = 'help';
    public $layout = 'account';
    public $defaultAction = 'help';
    
    public function actionHelp()
    {
        $this->render('help');
    }
}