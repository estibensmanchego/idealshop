<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Product\Controller;

use Product\Model\CategoryTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Product\Form\CategoryForm;
use Product\Model\Category;

class CategoryController extends AbstractActionController
{

	private $table;

    public function __construct(CategoryTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
		return new ViewModel([
            'categories' => $this->table->fetchAll(),
        ]);    	
    }

    public function addAction()
    {
    	$form = new CategoryForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $category = new Category();
        $form->setInputFilter($category->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $category->exchangeArray($form->getData());
        $this->table->saveCategory($category);
        return $this->redirect()->toRoute('category');
    }

    public function editAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('category', ['action' => 'add']);
        }

        // Retrieve the category with the specified id. Doing so raises
        // an exception if the category is not found, which should result
        // in redirecting to the landing page.
        try {
            $category = $this->table->getCategory($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('category', ['action' => 'index']);
        }

        $form = new CategoryForm();
        $form->bind($category);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($category->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveCategory($category);

        // Redirect to category list
        return $this->redirect()->toRoute('category', ['action' => 'index']);    	
    }

    public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('category');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteCategory($id);
            }

            // Redirect to list of categorys
            return $this->redirect()->toRoute('category');
        }

        return [
            'id'    => $id,
            'category' => $this->table->getCategory($id),
        ];    	
    }
}
