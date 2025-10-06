package com.fintech.cms.service;

import com.fintech.cms.dto.CreateCardRequest;
import com.fintech.cms.exception.ResourceNotFoundException;
import com.fintech.cms.model.Account;
import com.fintech.cms.model.Card;
import com.fintech.cms.model.Status;
import com.fintech.cms.repository.AccountRepository;
import com.fintech.cms.repository.CardRepository;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.modelmapper.ModelMapper;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.util.List;
import java.util.UUID;

@Service
@RequiredArgsConstructor
@Slf4j
public class CardService {

    private final CardRepository cardRepository;
    private final AccountRepository accountRepository;
    private final ModelMapper modelMapper;

    public Card createCard(CreateCardRequest cardDto, UUID account_Id) {
        Account account = accountRepository.findById(account_Id)
                .orElseThrow(() -> new ResourceNotFoundException("Account not found with id: " + account_Id));

        Card card = modelMapper.map(cardDto, Card.class);
        card.setAccount(account);
        card.setStatus(Status.Active);// default status
        Card saved = cardRepository.save(card);
        log.info("Created card with id {} for account {}", saved.getId(), account_Id);
        return saved;
    }

    public Card activateCard(String isbn) {
        Card card = getCardByCardNumber(isbn);
        card.setStatus(Status.Active);
        Card updated = cardRepository.save(card);
        log.info("Activated card with isbn {}", isbn);
        return updated;
    }

    public Card deactivateCard(String isbn) {
        Card card = getCardByCardNumber(isbn);
        card.setStatus(Status.NonActive);
        Card updated = cardRepository.save(card);
        log.info("Deactivated card with isbn {}", isbn);
        return updated;
    }

    public List<Card> getAllCards() {
        log.info("Fetching all cards");
        return cardRepository.findAll();
    }

    public Card getCardById(UUID cardId) {
        return cardRepository.findById(cardId)
                .orElseThrow(() -> new ResourceNotFoundException("Card not found with id: " + cardId));
    }
    public Card getCardByCardNumber(String CardNumber) {
        return cardRepository.findByCardNumber(CardNumber)
                .orElseThrow(() -> new ResourceNotFoundException("Card not found with id: " + CardNumber));
    }

    public boolean isCardValid(Card card) {
        return Status.Active.equals(card.getStatus()) &&
                !card.getExpiry().isBefore(LocalDate.now());
    }
}
