<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TodoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $todos = $this->getDoctrine()->getRepository('AppBundle:Todo')->findBy(array(), array('id' => 'DESC'));

        return $this->render('todo/index.html.twig', array(
            'todos' => $todos
        ));
    }

    /**
     * @Route("/todo/create", name="todo_create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $todo = new Todo();

        $form = $this->createFormBuilder($todo)
                     ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('category', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control')))
                     ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal' => 'Normal', 'High' => 'HIgh'), 'attr' => array('class' => 'form-control')))
                     ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'formcontrol')))
                     ->add('save', SubmitType::class, array('label' => 'Create task', 'attr' => array('class' => 'btn btn-primary')))
                     ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

            $now = new \DateTime('now');

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Added'
            );

            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findOneBy(array('id' => $id));

        $now = new \DateTime('now');

        $todo->setName($todo->getName());
        $todo->setCategory($todo->getCategory());
        $todo->setDescription($todo->getDescription());
        $todo->setPriority($todo->getPriority());
        $todo->setDueDate($todo->getDueDate());
        $todo->setCreateDate($now);

        $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('category', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control')))
            ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal' => 'Normal', 'High' => 'HIgh'), 'attr' => array('class' => 'form-control')))
            ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'formcontrol')))
            ->add('save', SubmitType::class, array('label' => 'Edit task', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('AppBundle:Todo')->find($id);

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);

            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Added'
            );

            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo/edit.html.twig', array(
            'todo' => $todo,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/todo/details/{id}", name="todo_details")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailsAction($id)
    {
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findOneBy(array('id' => $id));

        return $this->render('todo/details.html.twig', array(
            'todo' => $todo
        ));
    }

    /**
     * @Route("/todo/delete/{id}", name="todo_delete")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->find($id);

        $em->remove($todo);

        $em->flush();

        $this->addFlash(
            'notice',
            'Todo Removed'
        );

        return $this->redirectToRoute('todo_list');
    }
}
