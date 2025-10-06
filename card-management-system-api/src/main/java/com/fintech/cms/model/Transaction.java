package com.fintech.cms.model;

import com.fasterxml.jackson.annotation.JsonBackReference;
import jakarta.persistence.*;
import jakarta.validation.constraints.DecimalMin;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

import java.math.BigDecimal;
import java.time.LocalDateTime;
import java.util.UUID;

@Entity
@Data
@Table(name = "transactions")
public class Transaction {

    @Id
    @GeneratedValue
    private UUID id;

    @NotNull
    @DecimalMin(value = "0.0", inclusive = false, message = "Transaction amount must be greater than 0")
    @Column(nullable = false)
    private BigDecimal transactionAmount;

    @Column(nullable = false)
    private LocalDateTime transactionDate;

    @Enumerated(EnumType.STRING)
    @Column(nullable = false)
    private Type transactionType; // CREDIT or DEBIT

    @ManyToOne
    @JoinColumn(name = "cardNumber", nullable = false)
    @JsonBackReference
    private Card card;
    @NotNull
    @DecimalMin(value = "0.0", inclusive = false, message = "Transaction amount must be greater than 0")
    @Column(nullable = false)
    private BigDecimal oldBalance;

    @PrePersist
    protected void onCreate() {
        transactionDate = LocalDateTime.now();
    }
}
