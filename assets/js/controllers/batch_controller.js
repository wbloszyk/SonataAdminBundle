/*!
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  toggle() {
    const { checked } = this.checkboxAll;

    this.idxCheckboxes.forEach((checkbox) => {
      // avoid unnecessary event dispatching
      if (checkbox.checked === checked) {
        return;
      }

      // Update the checkbox state and dispatch an input event to notify any listeners
      checkbox.checked = checked;
      const event = new Event('change', { bubbles: true, cancelable: false });
      checkbox.dispatchEvent(event);

      // Update the row's selected state based on the checkbox state
      const row = checkbox.closest('tr, div.sonata-ba-list-field-batch');
      row?.classList.toggle('sonata-ba-list-row-selected', checked);
    });
  }

  get checkboxAll() {
    return this.element.querySelectorAll('#list_batch_checkbox')[0] ?? null;
  }

  get idxCheckboxes() {
    return this.element.querySelectorAll('input[type="checkbox"][name="idx[]"]');
  }
}
