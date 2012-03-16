<?php

namespace Etf1\ImaginizeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Etf1\ImaginizeBundle\Model\Comment;
use Etf1\ImaginizeBundle\Model\CommentQuery;
use Imagine\Image\Point;
use Imagine\Image\Box;
use Imagine\Image\Color;
use Etf1\ImaginizeBundle\Model\DisplayedNumber;
use Etf1\ImaginizeBundle\Model\DisplayedNumberQuery;

    const IMAGE_PER_LINE = 4;
    const IMAGE_PER_COLUMN = 4;
    const EXT = 'jpg';
    
class AdminController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('image', 'file')
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $image = $this->get('request')->request->get('image');
                $file = $form['image']->getData();
                $file->move('upload', 'image.' . EXT);
                $imagine = $this->get('liip_imagine');
                $image = $imagine->open('upload/image.' . EXT);

                $imageSize = $image->getSize();
                $newWidth = round($imageSize->getWidth() / IMAGE_PER_LINE) * IMAGE_PER_LINE;
                $newHeight = round($imageSize->getHeight() / IMAGE_PER_COLUMN) * IMAGE_PER_COLUMN;
                $imageSize = new Box($newWidth, $newHeight);

                $image->resize($imageSize);
                $image->save('upload/image.' . EXT);
                for ($i = 0; $i < IMAGE_PER_LINE * IMAGE_PER_COLUMN; $i++) {
                    $imageTemp = $image->copy();

                    $xSize = $imageSize->getWidth() / IMAGE_PER_LINE;
                    $ySize = $imageSize->getHeight() / IMAGE_PER_COLUMN;
                    $x = ($i % IMAGE_PER_LINE) * $xSize;
                    $y = floor($i / IMAGE_PER_LINE) * $ySize;

                     $imageTemp->crop(
                        new Point($x, $y),
                        new Box($xSize, $ySize)
                    );
                    $imageTemp->save(sprintf('upload/image%d.%s', $i, EXT));
                }
                $firstImage = $imagine->create($imageSize, new Color('000'));
                $firstImage->save('upload/agglomeratedImage0.' . EXT);

                $countImage = DisplayedNumberQuery::create()->count();
                if ($countImage == 1) {
                    $displayedNumbersObject = DisplayedNumberQuery::create()->findOne();
                } else {
                    $displayedNumbersObject = new DisplayedNumber();
                }
                $displayedNumbersObject->setNumbers(array());
                $displayedNumbersObject->save();

                CommentQuery::create()->deleteAll();
            }
        }
        
        return $this->render('Etf1ImaginizeBundle:Admin:index.html.twig', array(
            'form' => $form->createView(),
            'numberOfComments' => CommentQuery::create()->count()
        ));
    }
}