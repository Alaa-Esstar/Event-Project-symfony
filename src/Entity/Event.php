<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_valid;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_archive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=EventParticipant::class, mappedBy="Event", orphanRemoval=true)
     */
    private $eventParticipants;

    /**
     * @ORM\OneToMany(targetEntity=EventLogistoc::class, mappedBy="event", orphanRemoval=true, cascade={"persist"})
     */
    private $eventLogistocs;

    /**
     * @ORM\OneToMany(targetEntity=EventFeedback::class, mappedBy="Event", orphanRemoval=true)
     */
    private $eventFeedback;

    public function __construct()
    {
        $this->eventParticipants = new ArrayCollection();
        $this->eventLogistocs = new ArrayCollection();
        $this->eventFeedback = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->is_valid;
    }

    public function setIsValid(bool $is_valid): self
    {
        $this->is_valid = $is_valid;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsArchive(): ?bool
    {
        return $this->is_archive;
    }

    public function setIsArchive(?bool $is_archive): self
    {
        $this->is_archive = $is_archive;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, EventParticipant>
     */
    public function getEventParticipants(): Collection
    {
        return $this->eventParticipants;
    }

    public function addEventParticipant(EventParticipant $eventParticipant): self
    {
        if (!$this->eventParticipants->contains($eventParticipant)) {
            $this->eventParticipants[] = $eventParticipant;
            $eventParticipant->setEvent($this);
        }

        return $this;
    }

    public function removeEventParticipant(EventParticipant $eventParticipant): self
    {
        if ($this->eventParticipants->removeElement($eventParticipant)) {
            // set the owning side to null (unless already changed)
            if ($eventParticipant->getEvent() === $this) {
                $eventParticipant->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EventLogistoc>
     */
    public function getEventLogistocs(): Collection
    {
        return $this->eventLogistocs;
    }

    public function addEventLogistoc(EventLogistoc $eventLogistoc): self
    {
        if (!$this->eventLogistocs->contains($eventLogistoc)) {
            $this->eventLogistocs[] = $eventLogistoc;
            $eventLogistoc->setEvent($this);
        }

        return $this;
    }

    public function removeEventLogistoc(EventLogistoc $eventLogistoc): self
    {
        if ($this->eventLogistocs->removeElement($eventLogistoc)) {
            // set the owning side to null (unless already changed)
            if ($eventLogistoc->getEvent() === $this) {
                $eventLogistoc->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EventFeedback>
     */
    public function getEventFeedback(): Collection
    {
        return $this->eventFeedback;
    }

    public function addEventFeedback(EventFeedback $eventFeedback): self
    {
        if (!$this->eventFeedback->contains($eventFeedback)) {
            $this->eventFeedback[] = $eventFeedback;
            $eventFeedback->setEvent($this);
        }

        return $this;
    }

    public function removeEventFeedback(EventFeedback $eventFeedback): self
    {
        if ($this->eventFeedback->removeElement($eventFeedback)) {
            // set the owning side to null (unless already changed)
            if ($eventFeedback->getEvent() === $this) {
                $eventFeedback->setEvent(null);
            }
        }

        return $this;
    }
}
