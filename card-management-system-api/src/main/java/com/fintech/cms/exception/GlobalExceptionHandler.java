package com.fintech.cms.exception;

import com.google.rpc.Code;
import com.fintech.cms.dto.CustomResponse;
import jakarta.servlet.http.HttpServletRequest;
import org.springframework.context.MessageSource;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.MethodArgumentNotValidException;
import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.ResponseStatus;

import java.time.LocalDateTime;
import java.util.Locale;

@ControllerAdvice
public class GlobalExceptionHandler {

    private final MessageSource messageSource;

    public GlobalExceptionHandler(MessageSource messageSource) {
        this.messageSource = messageSource;
    }

    private String getLocalizedMessage(String code, Locale locale, String defaultMessage) {
        return messageSource.getMessage(code, null, defaultMessage, locale);
    }

    private <T> CustomResponse<T> buildResponse(Code code, String message, T data) {
        return new CustomResponse<>(code, message, data);
    }

    // 404 Resource Not Found
    @ExceptionHandler(ResourceNotFoundException.class)
    @ResponseStatus(HttpStatus.NOT_FOUND)
    @ResponseBody
    public CustomResponse<String> handleNotFound(ResourceNotFoundException ex, HttpServletRequest request) {
        Locale locale = request.getLocale();
        String message = getLocalizedMessage("error.not.found", locale, "Resource not found");
        return buildResponse(Code.NOT_FOUND, message, null);
    }

    // Validation errors
    @ExceptionHandler(MethodArgumentNotValidException.class)
    @ResponseStatus(HttpStatus.BAD_REQUEST)
    @ResponseBody
    public CustomResponse<String> handleValidation(MethodArgumentNotValidException ex, HttpServletRequest request) {
        Locale locale = request.getLocale();
        String message = ex.getBindingResult().getAllErrors().stream()
                .map(error -> error.getDefaultMessage())
                .findFirst()
                .orElse(getLocalizedMessage("error.validation", locale, "Validation failed"));
        return buildResponse(Code.INVALID_ARGUMENT, message, null);
    }

    // Illegal argument / bad requests
    @ExceptionHandler(IllegalArgumentException.class)
    @ResponseStatus(HttpStatus.BAD_REQUEST)
    @ResponseBody
    public CustomResponse<String> handleIllegalArgs(IllegalArgumentException ex, HttpServletRequest request) {
        Locale locale = request.getLocale();
        String message = getLocalizedMessage("error.bad.request", locale, ex.getMessage());
        return buildResponse(Code.INVALID_ARGUMENT, message, null);
    }

    // Generic / fallback handler
    @ExceptionHandler(Exception.class)
    @ResponseStatus(HttpStatus.INTERNAL_SERVER_ERROR)
    @ResponseBody
    public CustomResponse<String> handleAllExceptions(Exception ex, HttpServletRequest request) {
        Locale locale = request.getLocale();
        String message = getLocalizedMessage("error.internal.server", locale, "Internal server error");
        ex.printStackTrace();
        return buildResponse(Code.INTERNAL, message, null);
    }
}
