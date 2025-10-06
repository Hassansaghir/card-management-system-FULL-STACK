package com.fintech.cms.repository;

import com.fintech.cms.model.Card;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;
import java.util.UUID;

@Repository
public interface CardRepository extends JpaRepository<Card, UUID> {
    List<Card> findByAccount_Id(UUID accountId);

        Optional<Card> findByCardNumber(String cardNumber);
    }


