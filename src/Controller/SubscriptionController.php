<?php
namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscribe', name: 'subscribe')]
    public function subscribe(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Ensure the user is logged in
        if (!$user) {
            $this->addFlash('error', 'You must be logged in to subscribe.');
            return $this->redirectToRoute('login'); // Adjust the route as necessary
        }

        $packId = $request->query->get('packId'); // Get the pack ID from the URL
        if (!$packId) {
            $this->addFlash('error', 'Invalid pack selected.');
            return $this->redirectToRoute('homepage');
        }

        // Create a new subscription
        $subscription = new Subscription();
        $subscription->setUser($user->getId());
        $subscription->setPackId((int)$packId);
        $subscription->setStartDate(new \DateTime()); // Static start date
        $subscription->setEndDate(new \DateTime('+1 month')); // Adjust as needed
        $subscription->setPaymentMethod('cash'); // Static payment method

        // Persist the subscription
        $entityManager->persist($subscription);
        $entityManager->flush();

        $this->addFlash('success', 'You have successfully subscribed to the plan!');
        return $this->redirectToRoute('homepage');
    }
}
