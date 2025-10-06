package com.fintech.cms.dto;

import com.google.rpc.Code;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class CustomResponse<T> {
    private Code status;   // "success" or "error"
    private String message;  // optional message
    private T data;          // generic data
}
