package com.fintech.cms.controller;

import com.google.rpc.Code;
import com.fintech.cms.dto.*;
import com.fintech.cms.model.Account;
import com.fintech.cms.repository.AccountRepository;
import com.fintech.cms.repository.CardRepository;
import com.fintech.cms.service.AccountService;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.MessageSource;
import org.springframework.web.bind.annotation.*;
import java.util.*;
import org.springframework.cloud.context.config.annotation.RefreshScope;

@RestController
@RequestMapping("/v1/accounts")
@RequiredArgsConstructor
@Slf4j
@RefreshScope
public class AccountController {

    private final AccountService accountService;
    private final ModelMapper modelMapper;
    private final AccountRepository accountRepository;
    private final Maplist maplist;
    private final CardRepository cardRepository;
    private final MessageSource messageSource;

    @PostMapping
    public CustomResponse<AccountDTO> createAccount(@Valid @RequestBody CreateAccountRequest request,
                                                    HttpServletRequest httpRequest) {
        Locale locale = httpRequest.getLocale();
        Account created = accountService.createAccount(request);
        log.info("Account created with id {}", created.getId());

        AccountDTO accountDTO = modelMapper.map(created, AccountDTO.class);
        accountDTO.setCards(maplist.mapList(created.getCards(), CardDto.class));

        String message = messageSource.getMessage("account.created", null, locale);

        return new CustomResponse<>(Code.OK, message, accountDTO);
    }

    @GetMapping
    public CustomResponse<List<AccountDTO>> getAllAccounts(HttpServletRequest httpRequest) {
        Locale locale = httpRequest.getLocale();
        List<Account> accounts = accountService.getAllAccounts();
        List<AccountDTO> accountDTOS = maplist.mapList(accounts, AccountDTO.class);

        for (int i = 0; i < accounts.size(); i++) {
            UUID accountId = accounts.get(i).getId();
            List<CardDto> cardDtos = accountDTOS.get(i).getCards();
            if (cardDtos != null) {
                for (CardDto cardDto : cardDtos) {
                    cardDto.setAccount_id(accountId);
                }
            }
        }

        String message = messageSource.getMessage("account.fetched.all", null, locale);
        return new CustomResponse<>(Code.OK,message, accountDTOS);
    }

    @GetMapping("/{id}")
    public CustomResponse<AccountDTO> getAccountById(@PathVariable UUID id, HttpServletRequest httpRequest) {
        Locale locale = httpRequest.getLocale();
        Account account = accountService.getAccountById(id);
        log.info("Fetched account with id {}", id);

        AccountDTO accountDTO = modelMapper.map(account, AccountDTO.class);
        if (accountDTO.getCards() != null) {
            for (CardDto card : accountDTO.getCards()) {
                card.setAccount_id(account.getId());
            }
        }

        String message = messageSource.getMessage("account.fetched", null, locale);
        return new CustomResponse<>(Code.OK, message, accountDTO);
    }

    @PatchMapping("/{id}")
    public CustomResponse<AccountDTO> updateAccountPartially(@PathVariable UUID id,
                                                             @Valid @RequestBody UpdateAccountRequest request,
                                                             HttpServletRequest httpRequest) {
        Locale locale = httpRequest.getLocale();
        Account updated = accountService.updateAccountPartially(id, request);
        log.info("Patched account with id {}", id);

        AccountDTO accountDTO = modelMapper.map(updated, AccountDTO.class);
        if (accountDTO.getCards() != null) {
            for (CardDto card : accountDTO.getCards()) {
                card.setAccount_id(updated.getId());
            }
        }

        String message = messageSource.getMessage("account.patched", null, locale);
        return new CustomResponse<>(Code.OK, message, accountDTO);
    }

    @DeleteMapping("/{id}")
    public CustomResponse<String> deleteAccount(@PathVariable UUID id, HttpServletRequest httpRequest) {
        Locale locale = httpRequest.getLocale();
        accountService.deleteAccount(id);
        log.info("Deleted account with id {}", id);

        String message = messageSource.getMessage("account.deleted", null, locale);
        return new CustomResponse<>(Code.OK, message, null);
    }
}
