<?php

class BookController extends Controller
{

    public function actionIndex()
    {
        $mdl = new BookSearchForm;
        $results = array();
        if (!empty($_GET['BookSearchForm']['query'])) {
            $mdl->query = $_GET['BookSearchForm']['query'];
            $results = $mdl->search();
        }

        $this->render('search', array(
            'model'=>$mdl, 
            'books'=>$results,
        ));
    }

    public function actionRead($id) {
        $this->layout = false;
        $book = new Book($id);
        $this->render('read', array('book'=>$book));
    }

    public function actionVote($id, $vote) {
        $book = new Book($id);
        if ($vote == -1) {
            $book->nvote();
        } else {
            $book->vote();
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionView($id)
    {
        $book = new Book($id);
        $this->render('view', array ('book'=>$book));
    }

    // Uncomment the following methods and override them if needed
        /*
        public function filters()
        {
                // return the filter configuration for this controller, e.g.:
                return array(
                        'inlineFilterName',
                        array(
                                'class'=>'path.to.FilterClass',
                                'propertyName'=>'propertyValue',
                        ),
                );
        }

        public function actions()
        {
                // return external action classes, e.g.:
                return array(
                        'action1'=>'path.to.ActionClass',
                        'action2'=>array(
                                'class'=>'path.to.AnotherActionClass',
                                'propertyName'=>'propertyValue',
                        ),
                );
        }
         */
}
