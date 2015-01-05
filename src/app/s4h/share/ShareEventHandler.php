<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 22/11/14
 * Time: 14:29
 */

namespace s4h\share;
use s4h\Facades\Sharing;
use s4h\Facades\Notifications;

class ShareEventHandler {

    public function onShareCreated($event)
    {
        //Notificar al usuario via correo y en el área de notificaciones
        $sharedElement = $event;
        foreach($sharedElement->getSharedWith() as $sharedWith)
        {
            //Agregar entrada a la bitácora de notificaciones
            if ($sharedWith->getPersonId())
                Notifications::create('New Shared Element Created', $event->getClassName(), $sharedWith->getPersonId());
            //Enviar correo de notificación
            //Cambiar el estatus del elemento
            Sharing::changeShareDetailStatus($sharedWith->getId(), SharedElementDetailStatus::Sent);
        }
    }

    public function onShareAccepted($event)
    {
        //Agregar entrada a la bitácora de notificaciones
        Notifications::create("{$event->Share->class_name} {$event->id} was accepted by {$event->acceptedBy}","Shared element {$event->id} was accepted by {$event->acceptedBy}",$event->Share->person_id);
    }

    public function onShareRejected($event)
    {
        print("Shared element {$event->id} was rejected by {$event->person_id}");
    }

    public function subscribe($events)
    {
        $events->listen('sharing.*.wasCreated', 's4h\share\ShareEventHandler@onShareCreated');
        $events->listen('sharing.*.wasAccepted', 's4h\share\ShareEventHandler@onShareAccepted');
        $events->listen('sharing.*.wasRejected', 's4h\share\ShareEventHandler@onShareRejected');
    }
} 