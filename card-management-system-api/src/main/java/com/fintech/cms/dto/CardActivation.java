package com.fintech.cms.dto;

import com.fintech.cms.model.Status;
import jakarta.persistence.Column;
import jakarta.persistence.EnumType;
import jakarta.persistence.Enumerated;
import jakarta.validation.constraints.NotBlank;
import lombok.Data;

import java.time.LocalDate;
import java.util.UUID;
@Data
public class CardActivation {
    @Enumerated(EnumType.STRING)
    private Status status;

    @Column(nullable = false)
    @NotBlank(message = "localDate required")
    private LocalDate expiry;

    private UUID account_id;
}
