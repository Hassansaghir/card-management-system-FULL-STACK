package com.fintech.cms.service;

import com.fintech.cms.dto.CreateAccountRequest;
import com.fintech.cms.dto.UpdateAccountRequest;
import com.fintech.cms.exception.ResourceNotFoundException;
import com.fintech.cms.model.Account;
import com.fintech.cms.model.Card;
import com.fintech.cms.model.Status;
import com.fintech.cms.repository.AccountRepository;
import jakarta.persistence.EntityNotFoundException;
import lombok.RequiredArgsConstructor;
import lombok.Value;
import lombok.extern.slf4j.Slf4j;
import org.modelmapper.ModelMapper;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.List;
import java.util.UUID;

@Service
@RequiredArgsConstructor
@Slf4j
public class AccountService {

    private final AccountRepository accountRepository;
    private final ModelMapper modelMapper;

    public Account createAccount(CreateAccountRequest request) {
        Account account = modelMapper.map(request, Account.class);
        account.setStatus(Status.Active);
        account.setCards(new ArrayList<>());
        Account saved = accountRepository.save(account);
        log.info("Created account with id {} with {} cards", saved.getId(),
                saved.getCards() != null ? saved.getCards().size() : 0);
        return saved;
    }

    public List<Account> getAllAccounts() {
        log.info("Fetching all accounts");
        return accountRepository.findAll();
    }

    public Account getAccountById(UUID id) {
        log.info("Fetching account with id {}", id);
        return accountRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Account not found with id: " + id));
    }

    public Account updateAccountPartially(UUID id, UpdateAccountRequest request) {
        Account account = accountRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Account not found with id: " + id));

        modelMapper.map(request, account);

        Account updated = accountRepository.save(account);
        log.info("Updated account with id {}", updated.getId());
        return updated;
    }

    public void deleteAccount(UUID id) {
        Account account = getAccountById(id); // This already throws ResourceNotFoundException if not found
        accountRepository.delete(account);
        log.info("Deleted account with id {}", id);
    }
}
