package com.fintech.cms.service;

import com.fintech.cms.dto.CreateTransactionRequest;
import com.fintech.cms.exception.InvalidOperationException;
import com.fintech.cms.exception.ResourceNotFoundException;
import com.fintech.cms.model.*;
import com.fintech.cms.repository.AccountRepository;
import com.fintech.cms.repository.CardRepository;
import com.fintech.cms.repository.TransactionRepository;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.modelmapper.ModelMapper;
import org.springframework.stereotype.Service;

import java.math.BigDecimal;
import java.time.LocalDateTime;
import java.util.List;
import java.util.UUID;

@Service
@RequiredArgsConstructor
@Slf4j
public class TransactionService {

    private final TransactionRepository transactionRepository;
    private final AccountRepository accountRepository;
    private final CardRepository cardRepository;
    private final ModelMapper modelMapper;

    // Create a new transaction
    public Transaction createTransaction(CreateTransactionRequest request, String CardNumber) {
        Card card = cardRepository.findByCardNumber(CardNumber)
                .orElseThrow(() -> new ResourceNotFoundException("Card not found with Number: " + CardNumber));

        if (card.getStatus() != Status.Active || card.getExpiry().isBefore(LocalDateTime.now().toLocalDate())) {
            throw new InvalidOperationException("Card is invalid or expired");
        }

        Account account = card.getAccount();
        if (account == null) throw new InvalidOperationException("Card is not linked to an account");
        if (account.getStatus() != Status.Active) throw new InvalidOperationException("Account is inactive");

        BigDecimal amount = request.getTransactionAmount();
        Type type = request.getTransactionType();
        BigDecimal oldBalance = account.getBalance();
        if (type == Type.D) { // Debit
            if (account.getBalance().compareTo(amount) < 0) {
                throw new InvalidOperationException("Insufficient balance");
            }
            account.setBalance(account.getBalance().subtract(amount));
        } else if (type == Type.C) { // Credit
            account.setBalance(account.getBalance().add(amount));
        } else {
            throw new InvalidOperationException("Invalid transaction type");
        }

        accountRepository.save(account);

        // Map DTO to entity
        Transaction transaction = modelMapper.map(request, Transaction.class);
        transaction.setCard(card); // set relation
        transaction.setTransactionDate(LocalDateTime.now()); // timestamp
        transaction.setOldBalance(oldBalance);
        Transaction saved = transactionRepository.save(transaction);
        log.info("Created {} transaction of {} for card {} and account {}",
                type, amount, CardNumber, account.getId());


        return saved;
    }


    // Get all transactions
    public List<Transaction> getAllTransactions() {
        List<Transaction> transactions = transactionRepository.findAll();
        log.info("Fetched {} transactions", transactions.size());
        return transactions;
    }

    // Get transaction by ID
    public Transaction getTransactionById(UUID id) {
        Transaction transaction = transactionRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Transaction not found with id: " + id));
        log.info("Fetched transaction with id {}", id);
        return transaction;
    }


}
