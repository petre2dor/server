<?php
// SPDX-FileCopyrigthText: Carl Schwan <carl@carlschwan.eu>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCP\DataCollector;

/**
 * Manager allowing to add DataCollector
 */
interface IManager {
	public function registerDataCollector(IDataCollector $dataCollector): void;
}
