<?php

namespace App\Handler;

use App\Command\UpdateObservationCommand;
use App\Contract\ObservationRepositoryInterface;
use App\Entity\User;
use App\Exception\UserIsNotResourceOwnerException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdateObservationHandler
{
    public function __construct(
        private readonly ObservationRepositoryInterface $observationRepository,
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {}

    public function __invoke(UpdateObservationCommand $command, User $user): void
    {
        $observation = $this->observationRepository->findOneByUuid($command->uuid);
        $userIsNotResourceOwner = $observation->getProvider() !== $user;
        $userIsNotAdmin = !$this->authorizationChecker->isGranted('ROLE_ADMIN');

        if ($userIsNotResourceOwner && $userIsNotAdmin) {
            throw new UserIsNotResourceOwnerException();
        }

        if (null !== $command->name && $observation->getName() !== $command->name) {
            $observation->setName($command->name);
        }

        $this->observationRepository->update();
    }
}