package com.fintech.cms.controller;

import com.google.rpc.Code;
import com.fintech.cms.dto.*;
import com.fintech.cms.model.Card;
import com.fintech.cms.service.CardService;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.modelmapper.ModelMapper;
import org.springframework.context.MessageSource;
import org.springframework.web.bind.annotation.*;

import jakarta.validation.Valid;
import java.util.List;
import java.util.Locale;
import java.util.UUID;

@RestController
@RequestMapping("/v1/cards")
@RequiredArgsConstructor
@Slf4j
public class CardController {

    private final CardService cardService;
    private final ModelMapper modelMapper;
    private final Maplist maplist;
    private final MessageSource messageSource;

    // Create a new card for an account
    @PostMapping("/{accountId}")
    public CustomResponse<CardDto> createCard(@Valid @RequestBody CreateCardRequest request,
                                                        @PathVariable UUID accountId,
                                                        Locale locale) {
        Card savedCard = cardService.createCard(request, accountId);
        CardDto cardRequest = modelMapper.map(savedCard, CardDto.class);
        cardRequest.setAccount_id(request.getAccount_id());
        log.info("Created card with id {} for account {}", savedCard.getId(), accountId);

        String message = messageSource.getMessage("card.created", null, locale);
        return new CustomResponse<>(Code.OK, message, cardRequest);
    }

    // Get all cards
    @GetMapping
    public CustomResponse<List<CardDto>> getAllCards(Locale locale) {
        List<Card> cards = cardService.getAllCards();
        log.info("Fetched {} cards", cards.size());

        List<CardDto> cardDtos = maplist.mapList(cards, CardDto.class);
        for (int i = 0; i < cards.size(); i++) {
            cardDtos.get(i).setAccount_id(cards.get(i).getAccount().getId());
        }

        String message = messageSource.getMessage("card.fetched.all", null, locale);
        return new CustomResponse<>(Code.OK, message, cardDtos);
    }

    // Get card by card number
    @GetMapping("/{cardNumber}")
    public CustomResponse<CardDto> getCardByNumber(@PathVariable String cardNumber, Locale locale) {
        Card card = cardService.getCardByCardNumber(cardNumber);
        log.info("Fetched card with number {}", cardNumber);

        CardDto cardDto = modelMapper.map(card, CardDto.class);
        cardDto.setAccount_id(card.getAccount().getId());

        String message = messageSource.getMessage("card.fetched", null, locale);
        return new CustomResponse<>(Code.OK, message, cardDto);
    }

    // Activate card
    @PutMapping("/activate/{CardNumber}")
    public CustomResponse<CardActivation> activateCard(@PathVariable String CardNumber, Locale locale) {
        Card card = cardService.activateCard(CardNumber);
        CardActivation cardActivation = modelMapper.map(card, CardActivation.class);
        cardActivation.setAccount_id(card.getAccount().getId());

        log.info("Activated card with cardNumber {}", CardNumber);
        String message = messageSource.getMessage("card.activated", null, locale);
        return new CustomResponse<>(Code.OK, message, cardActivation);
    }

    // Deactivate card
    @PutMapping("/deactivate/{CardNumber}")
    public CustomResponse<CardActivation> deactivateCard(@PathVariable String CardNumber, Locale locale) {
        Card card = cardService.deactivateCard(CardNumber);
        CardActivation cardActivation = modelMapper.map(card, CardActivation.class);
        cardActivation.setAccount_id(card.getAccount().getId());

        log.info("Deactivated card with CardNumber {}", CardNumber);
        String message = messageSource.getMessage("card.deactivated", null, locale);
        return new CustomResponse<>(Code.OK, message, cardActivation);
    }
}
