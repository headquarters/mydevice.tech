/* eslint-disable no-restricted-globals */
import { LitElement, html, css } from 'lit';
import { property } from 'lit/decorators.js';

// const logo = new URL('../../assets/open-wc-logo.svg', import.meta.url).href;

export class MyDevice extends LitElement {
  @property({ type: Number }) screenWidth = 0;

  @property({ type: Number }) screenHeight = 0;

  @property({ type: Number }) fullScreenWidth = 0;

  @property({ type: Number }) fullScreenHeight = 0;

  @property({ type: Boolean }) cookiesEnabled = true;

  @property({ type: String }) userAgent = '';

  constructor() {
    super();

    this.screenWidth = document.documentElement.clientWidth;
    this.screenHeight = document.documentElement.clientHeight;
    this.fullScreenWidth = screen.width;
    this.fullScreenHeight = screen.height;
    this.cookiesEnabled = navigator.cookieEnabled;
    this.userAgent = navigator.userAgent;
  }

  static styles = css`
    dl dd {
      font-family: monospace;
    }
  `;

  render() {
    return html`
      <main>
        <h1>My Device</h1>

        <dl>
          <dt>IP address</dt>
          <dd><em>must be replaced by a server</em></dd>

          <dt>Browser dimensions (width by height)</dt>
          <dd>${this.screenWidth}px by ${this.screenHeight}px</dd>

          <dt>Screen dimensions (width by height)</dt>
          <dd>${this.fullScreenWidth}px by ${this.fullScreenHeight}px</dd>

          <dt>User agent</dt>
          <dd>${this.userAgent}</dd>

          <dt>Cookies enabled</dt>
          <dd>${this.cookiesEnabled}</dd>
        </dl>
      </main>

      <footer>A simple web component app by Michael Head.</footer>
    `;
  }
}
