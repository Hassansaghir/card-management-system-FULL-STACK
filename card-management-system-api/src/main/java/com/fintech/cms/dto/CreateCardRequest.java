package com.fintech.cms.dto;

import jakarta.persistence.PrePersist;
import jakarta.validation.constraints.*;
import lombok.Data;

import java.math.BigDecimal;
import java.time.LocalDate;
import java.util.UUID;

@Data
public class CreateCardRequest {


    @NotNull(message = "Expiry date is required")
    @Future(message = "Expiry date must be in the future")
    private LocalDate expiry;
    @NotNull(message = "account id is required")
    private UUID account_id;


}
