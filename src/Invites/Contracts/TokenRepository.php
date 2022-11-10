<?php

namespace Orvital\Auth\Invites\Contracts;

use Orvital\Auth\Invites\Contracts\CanBeInvited as CanBeInvitedContract;

interface TokenRepository
{
    /**
     * Create a new token.
     */
    public function create(CanBeInvitedContract $user): string;

    /**
     * Determine if a token record exists and is valid.
     */
    public function exists(CanBeInvitedContract $user, string $token): bool;

    /**
     * Determine if the given user recently created a token.
     */
    public function recentlyCreatedToken(CanBeInvitedContract $user): bool;

    /**
     * Delete a token record.
     */
    public function delete(CanBeInvitedContract $user): void;

    /**
     * Delete expired tokens.
     */
    public function deleteExpired(): void;
}
