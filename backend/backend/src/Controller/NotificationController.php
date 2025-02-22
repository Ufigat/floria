<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NotificationController extends AbstractController
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository
    ) {
    }

    #[Route('/notifications', name: 'app_notification_index', methods: ['GET'])]
    public function index(int $page = 1, int $limit = 10): JsonResponse
    {
        $notifications = $this->notificationRepository->findWithPagination($page, $limit);

        $totalPages = ceil($notifications->count() / $limit);

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'totalPages' => $totalPages,
            'notifications' => $notifications->getIterator()->getArrayCopy(),
        ]);
    }

    #[Route('/create', name: 'app_notification_create', methods: ['POST'])]
    public function create(
        Request              $request,
        FormFactoryInterface $formFactory,
        ValidatorInterface   $validator
    ): JsonResponse
    {

        $form = $formFactory->createBuilder()
            ->add('to', EmailType::class)
            ->add('from', EmailType::class)
            ->add('body', TextareaType::class)
            ->getForm();

        $form->submit(json_decode($request->getContent(), true));

        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $data = $form->getData();

        $notification = $this->notificationRepository->save(
            new Notification(
                recipientEmail: $data['to'],
                senderEmail: $data['from'],
                message: $data['body'],
            ));

        return $this->json([
            'message' => 'Notification created successfully',
            'notification' => [
                'recipientEmail' => $notification->getRecipientEmail(),
                'senderEmail' => $notification->getSenderEmail(),
                'message' => $notification->getMessage(),
            ]
        ], Response::HTTP_CREATED);
    }
}
