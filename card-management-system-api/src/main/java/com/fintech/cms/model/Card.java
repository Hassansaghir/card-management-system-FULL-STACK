package com.fintech.cms.model;

import com.fasterxml.jackson.annotation.JsonBackReference;
import jakarta.persistence.*;
import jakarta.validation.constraints.Future;
import jakarta.validation.constraints.NotBlank;
import lombok.Data;

import java.time.LocalDate;
import java.util.UUID;

@Entity
@Data
@Table(name = "cards")
public class
Card {

    @Id
    @GeneratedValue
    private UUID id;

    @Column(nullable = false, unique = true, length = 16)
    @NotBlank
    private String cardNumber;

    @PrePersist
    public void generateCardNumber() {
        if (this.cardNumber == null || this.cardNumber.isEmpty()) {
            // Example: generate a random 16-character card number
            this.cardNumber = UUID.randomUUID().toString().replace("-", "").substring(0, 16);
        }
    }

    @Enumerated(EnumType.STRING)
    private Status status;

    @Future
    @Column(nullable = false)
    private LocalDate expiry;

    @ManyToOne(fetch = FetchType.EAGER)
    @JoinColumn(name = "account_id", nullable = false)
    @JsonBackReference
    private Account account;

}
