<?php

namespace Etf1\ImaginizeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Etf1\ImaginizeBundle\Model\Comment;
use Etf1\ImaginizeBundle\Model\CommentQuery;
use Etf1\ImaginizeBundle\Model\DisplayedNumber;
use Etf1\ImaginizeBundle\Model\DisplayedNumberQuery;
use Imagine\Image\Point;
use Imagine\Image\Box;
use Imagine\Image\Color;

    const IMAGE_PER_LINE = 4;
    const IMAGE_PER_COLUMN = 4;
    const EXT = 'jpg';

class IndexController extends Controller
{
    public function indexAction(Request $request)
    {
        header("Cache-Control: no-cache, must-revalidate");
        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
            ->add('value', 'text')
            ->getForm();

        $numberOfComments = CommentQuery::create()->count();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $comment->save();
                if ($numberOfComments <= IMAGE_PER_LINE * IMAGE_PER_COLUMN) {
                    $this->createImage(++$numberOfComments);
                }
            }
        }

        $imageNumber = ($numberOfComments < IMAGE_PER_LINE * IMAGE_PER_COLUMN) ? $numberOfComments : IMAGE_PER_LINE * IMAGE_PER_COLUMN;
        return $this->render('Etf1ImaginizeBundle:Index:index.html.twig', array(
            'form' => $form->createView(),
            'numberOfComments' => $numberOfComments,
            'image' => sprintf('/upload/agglomeratedImage%d.%s', $imageNumber, EXT)
        ));
    }

    private function createImage($numberOfComments) {
        $imagine = $this->get('liip_imagine');
        
        $image = $imagine->open(sprintf('upload/agglomeratedImage%d.%s', $numberOfComments - 1, EXT));
        $imageSize = $image->getSize();
        $xSize = $imageSize->getWidth() / IMAGE_PER_LINE;
        $ySize = $imageSize->getHeight() / IMAGE_PER_COLUMN;
        
        $displayedNumbersObject = DisplayedNumberQuery::create()->findOne();
        $displayedNumbers = $displayedNumbersObject->getNumbers();
        do {
            $newNumber = rand(0, IMAGE_PER_LINE * IMAGE_PER_COLUMN - 1);
        } while (in_array($newNumber, $displayedNumbers));

        $displayedNumbers[] = $newNumber;
        $displayedNumbersObject->setNumbers($displayedNumbers);

        $photo = $imagine->open(sprintf('upload/image%d.%s', $newNumber, EXT));

        $x = ($newNumber % IMAGE_PER_LINE) * $xSize;
        $y = floor($newNumber / IMAGE_PER_LINE) * $ySize;

        $image->paste($photo, new Point($x, $y));

        $image->save(sprintf('upload/agglomeratedImage%d.%s', $numberOfComments, EXT));
        $displayedNumbersObject->save();
    }
}