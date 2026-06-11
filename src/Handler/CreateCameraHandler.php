<?php

namespace App\Handler;

use App\Dto\CreateCamera;
use App\Entity\Camera;
use App\Entity\Competition;
use App\Enum\Camera\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CreateCameraHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(CreateCamera $input): Camera
    {
        $competitionId = $this->extractCompetitionId($input->competition);

        $competition = $this->entityManager->find(Competition::class, $competitionId);

        if (!$competition instanceof Competition) {
            throw new NotFoundHttpException('Competition introuvable.');
        }

        $camera = new Camera();
        $camera->setId($input->id);
        $camera->setName($input->name);
        $camera->setLocation($input->location);
        $camera->setRtmpUrl($input->rtmpUrl);
        $camera->setHlsUrl($input->hlsUrl);
        $camera->setAuthorized($input->authorized);
        $camera->setToken($input->token);
        $camera->setBlocked($input->blocked);
        $camera->setAllowedPaths($input->allowedPaths);

        if ($input->lastSeenAt instanceof \DateTimeImmutable) {
            $camera->setLastSeenAt($input->lastSeenAt);
        }

        $camera->setLastIp($input->lastIp);
        $camera->setLastProtocol($input->lastProtocol);
        $camera->setCurrentPath($input->currentPath);
        $camera->setStatus(Status::OFFLINE);
        $camera->setCompetition($competition);

        $this->entityManager->persist($camera);
        $this->entityManager->flush();

        return $camera;
    }

    private function extractCompetitionId(string $competition): int
    {
        if (!preg_match('#^/api/competitions/(\d+)$#', $competition, $matches)) {
            throw new BadRequestHttpException('Le champ competition doit etre une IRI valide.');
        }

        return (int) $matches[1];
    }
}