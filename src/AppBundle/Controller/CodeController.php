<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CodeSettings;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CodeController
 * @package AppBundle\Controller
 * @Route ("/code")
 */

class CodeController extends Controller
{
    /**
     * @Route("/create", name="create_code")
     */
    public function createAction(Request $request)
    {
        $codeSettings = new CodeSettings();
        $viewArray = array();

        $form = $this->createFormBuilder($codeSettings)
            ->add('numberOfCodes', IntegerType::class)
            ->add('length', IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $codeGenerator = $this->get('app.code_generator');
                $codeGenerator->setParameters($codeSettings);
                $filename = $codeGenerator->generateCodes();
                $viewArray['filename'] = $filename;
            } catch (\Exception $e) {
                $errorLog = $e->getMessage();
            }

        }

        $viewArray['form'] = $form->createView();
        return $this->render(':code:create.html.twig', $viewArray);
    }

}