<?php
use Symfony\Component\Form\Test\TypeTestCase;
use AppBundle\Entity\Truck;
use AppBundle\Form\TruckEditType;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;

/**
 * TruckEditTypeTest
 * tests for the truck form edit type
 *
 * @version 1.0
 * @author cst206
 */
class TruckEditTypeTest extends TypeTestCase
{
    /**
     * This method is required to allow the test to run
     * @return ValidatorExtension[]
     */
    protected function getExtensions()
    {
        return array(new ValidatorExtension(Validation::createValidator()));
    }

    private $truck;

    //**EDIT TYPE TEST**\\
    /**
     * S40A
     * Tests that the form class can be created and submit data
     */
    public function testSubmitData()
    {
        $this->truck = (new Truck())
            ->setTruckId("000033")
            ->setType   ("Large");

        // The data that will be "submitted" to the form
        $formData = array(
            'truckId' => $this->truck->getTruckId(),
            'type'    => $this->truck->getType   ()
        );

        //create a new form
        $form = $this->factory->create(TruckEditType::class, new Truck());

        $object = new Truck();
        //populate the new truck with the data
        foreach ($formData as $key=>$value)
        {
            $methodName = "set" . $key;
            $object->$methodName($value);
        }

        //submit the data
        $form->submit($formData);

        //Make sure the from doesent throw exceptions
        $this->assertTrue($form->isSynchronized());
        //Check that the form contains the objects info.
        $this->assertEquals($object,$form->getData());
        //create the forms view
        $view = $form->createView();
        //get the children of the form
        $children = $view->children;
        //make sure the form has all the right fields
        foreach ($formData as $key=>$value)
        {
            $this->assertArrayHasKey($key,$children);
        }
    }
}