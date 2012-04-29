<?
/**
 *
 *
 */
class BookSearchForm extends CFormModel {

    public $query;

    public function search() {
        $bs = new BooksService;
        $coll = $bs->search($this->query);
        return $coll;
    }
}
?>
