<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Subscribe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class UserPageController extends AbstractController
{
    #[Route('/user/{id}', name: 'app_user')]
    public function index(int $id, EntityManagerInterface $entityManager, Security $security): Response
    {
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Check if the current user is the owner of the profile
        $currentUser = $security->getUser();
        $isOwner = ($currentUser && $currentUser->getId() === $user->getId());

        // fetch user subscribes
        $subscribeRepository = $entityManager->getRepository(Subscribe::class);
        $subscribes = $subscribeRepository->getUserSubscribes($user);
        $subscribes_books = [];
        foreach ($subscribes as $subscribe) {
            $subscribes_books[] = $subscribe->getBook();
        }

        // fetch user comments
        $commentRepository = $entityManager->getRepository(Comment::class);
        $comments = $commentRepository->findBy(['commenter' => $user]);

        $birthday = $user->getBirthday();
        $age = $birthday ? $birthday->diff(new \DateTime())->y : null;

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'subscribes' => $subscribes_books,
            'comments' => $comments,
            'age' => $age,
            'isOwner' => $isOwner, // Pass the isOwner variable to the template
        ]);
    }

    #[Route('/user/update/displayname', name: 'app_user_update_displayname', methods: ['POST'])]
    public function updateDisplayName(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Retrieve the current user or use your authentication logic to fetch the user
        $currentUser = $this->getUser();
        $displayName = $data['displayName'];

        // Update the user's display name
        $currentUser->setDisplayName($displayName);

        // Save the changes to the database using the entity manager
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($currentUser);
        $entityManager->flush();

        // Return a JSON response indicating success
        return $this->json(['message' => 'Display name updated']);
    }

    #[Route('/user/update/gender', name: 'app_user_update_gender', methods: ['POST'])]
    public function updateGender(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Retrieve the current user or use your authentication logic to fetch the user
        $currentUser = $this->getUser();
        $gender = $data['gender'];

        // Update the user's gender
        $currentUser->setGender($gender);

        // Save the changes to the database using the entity manager
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($currentUser);
        $entityManager->flush();

        // Return a JSON response indicating success
        return $this->json(['message' => 'Gender updated']);
    }

    #[Route('/user/update/age', name: 'app_user_update_age', methods: ['POST'])]
    public function updateAge(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Retrieve the current user or use your authentication logic to fetch the user
        $currentUser = $this->getUser();
        $age = $data['age'];

        // Update the user's age
        $currentUser->setAge($age);

        // Save the changes to the database using the entity manager
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($currentUser);
        $entityManager->flush();

        // Return a JSON response indicating success
        return $this->json(['message' => 'Age updated']);
    }

    #[Route('/user/update/city', name: 'app_user_update_city', methods: ['POST'])]
    public function updateCity(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Retrieve the current user or use your authentication logic to fetch the user
        $currentUser = $this->getUser();
        $city = $data['city'];

        // Update the user's city
        $currentUser->setCity($city);

        // Save the changes to the database using the entity manager
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($currentUser);
        $entityManager->flush();

        // Return a JSON response indicating success
        return $this->json(['message' => 'City updated']);
    }
}
