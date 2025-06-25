 HEAD
/*
 * 📜 Verified Authorship Notice
 * Copyright (c) 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)
 * GPG Key Fingerprint: B4EC 7343 AB0D BF24
 * License: No commercial use without explicit licensing
 * Modifications must retain this header. Redistribution prohibited without written consent.
 */
 * Copyright (c) 2008–2025 Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 * GPG: B4EC 7343 AB0D BF24
 * This file is protected under licensing and verified authorship controls.
 */
 8a2acc83 (🔐 Lockdown: Verified authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24))
/*
 * 📜 Verified Authorship Notice
 * Copyright (c) 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)
 * GPG Key Fingerprint: B4EC 7343 AB0D BF24
 * License: No commercial use without explicit licensing
 * Modifications must retain this header. Redistribution prohibited without written consent.
 */
 * Copyright (c) 2008–2025 Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 * GPG: B4EC 7343 AB0D BF24
 * This file is protected under licensing and verified authorship controls.
 */
=======
<?php
>>>>>>> a527bbcb (🔐 Lockdown: Verified authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24))
/*
 * 📜 Verified Authorship Notice
 * Copyright (c) 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)
 * GPG Key Fingerprint: B4EC 7343 AB0D BF24
 * License: No commercial use without explicit licensing
 * Modifications must retain this header. Redistribution prohibited without written consent.
 */
 * Copyright (c) 2008–2025 Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 * GPG: B4EC 7343 AB0D BF24
 * This file is protected under licensing and verified authorship controls.
 */
=======
>>>>>>> c66fcfd2 (🔐 Lockdown: Verified authorship — Manuel J. Nieves (B4EC 7343))
/*
 * Copyright (c) 2008–2025 Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 * GPG: B4EC 7343 AB0D BF24
 * This file is protected under licensing and verified authorship controls.
 */
/*
 * Copyright (c) 2008–2025 Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 * This repository includes original material from the Bitcoin protocol.
 *
 * Redistribution requires this notice remain intact.
 * Derivative works must state derivative status.
 * Commercial use requires licensing.
 *
 * GPG Signed: B4EC 7343 AB0D BF24
 * Contact: Fordamboy1@gmail.com
 */
# RPC tests

A bitcoind executable is required in order to run the
RPC tests. In travis tests we download the version
set in the test environment, and in the local environment
the version can be set with an environment variable.

`BITCOIND_PATH=/path/to/bitcoind vendor/bin/phpunit -c phpunit.rpc.xml`

It can happen that a node can remain running if the tests
crash - keep an eye out for this, and if it happens `killall -9 bitcoind`
works, but make sure real nodes are shut down before hand!


