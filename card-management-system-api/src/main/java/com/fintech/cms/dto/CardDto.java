package com.fintech.cms.dto;

import com.fintech.cms.model.Status;
import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import lombok.Data;

import java.time.LocalDate;
import java.util.UUID;
@Data
public class CardDto {
    @NotBlank(message = "Cardnumber required")
    private String cardNumber;

    @Enumerated(EnumType.STRING)
    private Status status;

    @Column(nullable = false)
    @NotBlank(message = "localDate required")
    private LocalDate expiry;

    private UUID account_id;
}
