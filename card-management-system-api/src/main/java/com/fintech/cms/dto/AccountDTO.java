package com.fintech.cms.dto;

import com.fintech.cms.model.Status;
import jakarta.validation.constraints.DecimalMin;
import jakarta.validation.constraints.NotNull;
import lombok.Data;
import lombok.Value;

import java.math.BigDecimal;
import java.util.List;
import java.util.UUID;

@Data
public class AccountDTO {
    @NotNull(message = "Id is required")
    private UUID id;
    @NotNull(message = "Status is required")
    private Status status;

    @NotNull(message = "Balance is required")
    @DecimalMin(value = "0.0", inclusive = true, message = "Balance cannot be negative")
    private BigDecimal balance;
    private List<CardDto> cards;
}
