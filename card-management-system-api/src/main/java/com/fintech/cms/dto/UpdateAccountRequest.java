package com.fintech.cms.dto;

import com.fintech.cms.model.Status;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

import java.math.BigDecimal;

@Data
public class UpdateAccountRequest {

    @NotNull(message = "Status is required")
    private Status status;

    private BigDecimal balance;
}
