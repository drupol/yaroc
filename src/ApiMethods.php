<?php

declare(strict_types=1);

namespace drupol\Yaroc;

enum ApiMethods: string
{
    case AddDelegation = 'addDelegation';

    case BeginGiveaway = 'beginGiveaway';

    case ContinueGiveaway = 'continueGiveaway';

    case CreateTickets = 'createTickets';

    case DelegationAdded = 'delegationAdded';

    case DelegationRemoved = 'delegationRemoved';

    case GenerateBlobs = 'generateBlobs';

    case GenerateDecimalFractions = 'generateDecimalFractions';

    case GenerateGaussians = 'generateGaussians';

    case GenerateIntegers = 'generateIntegers';

    case GenerateIntegerSequences = 'generateIntegerSequences';

    case GenerateSignedBlobs = 'generateSignedBlobs';

    case GenerateSignedDecimalFractions = 'generateSignedDecimalFractions';

    case GenerateSignedGaussians = 'generateSignedGaussians';

    case GenerateSignedIntegers = 'generateSignedIntegers';

    case GenerateSignedIntegerSequences = 'generateSignedIntegerSequences';

    case GenerateSignedStrings = 'generateSignedStrings';

    case GenerateSignedUUIDs = 'generateSignedUUIDs';

    case GenerateStrings = 'generateStrings';

    case GenerateUUIDs = 'generateUUIDs';

    case GetDraw = 'getDraw';

    case GetGiveaway = 'getGiveaway';

    case GetResult = 'getResult';

    case GetTicket = 'getTicket';

    case GetUsage = 'getUsage';

    case HoldDraw = 'holdDraw';

    case ListDelegations = 'listDelegations';

    case ListDraws = 'listDraws';

    case ListGiveaways = 'listGiveaways';

    case ListTickets = 'listTickets';

    case RemoveDelegation = 'removeDelegation';

    case RevealTickets = 'revealTickets';

    case SetNotificationHandler = 'setNotificationHandler';

    case VerifySignature = 'verifySignature';
}
