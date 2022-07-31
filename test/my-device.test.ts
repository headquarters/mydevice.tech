import { html } from 'lit';
import { fixture, expect } from '@open-wc/testing';

import { MyDevice } from '../src/MyDevice.js';
import '../src/my-device.js';

describe('MyDevice', () => {
  let element: MyDevice;
  beforeEach(async () => {
    element = await fixture(html`<my-device></my-device>`);
  });

  it('renders a h1', () => {
    const h1 = element.shadowRoot!.querySelector('h1')!;
    expect(h1).to.exist;
    expect(h1.textContent).to.equal('My Device');
  });

  it('passes the a11y audit', async () => {
    await expect(element).shadowDom.to.be.accessible();
  });
});
