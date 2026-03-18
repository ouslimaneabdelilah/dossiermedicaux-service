<?php

namespace App\Jobs;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;
use App\Services\DossierMedicalServices;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class SyncPatientJob extends RabbitMQJob{

    /**
     * Execute the job.
     */
    public function fire(): void{
        $folderService = $this->container->make(DossierMedicalServices::class);
        try{
            $raw = json_decode($this->getRawBody(), true);
            $routingKey = $this->getRabbitMQMessage()->delivery_info['routing_key'] ?? '';

            $body = $raw['body'] ?? null;
            $payload = is_string($body) ? (json_decode($body, true) ?? $raw) : ($body ?? $raw);

            match($routingKey){
                'patient.created' => $folderService->store($payload),
                'patient.deleted' => $folderService->deleteByPatientUuid($payload['patient_id']),
                default => Log::warning("Dossier service recieved an event with unknown routing key $routingKey")
            };
            $this->delete();
        }catch(Throwable $e){
            Log::error('SyncPatientJob fire() failed', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile() . ':' . $e->getLine(),
                'raw'   => $this->getRawBody(),
            ]);
            throw $e;
        }
    }
    public function payload(){
        return [
            'uuid'        => Str::uuid()->toString(),
            'displayName' => 'NotificationJob',
            'job'         => 'SyncPatientJob',
            'data'        => [],
        ];
    }
    public function getName(){
        return "SyncPatientJob";
    }
}
