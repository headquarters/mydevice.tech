import { html, TemplateResult } from 'lit';
import '../src/my-device.js';

export default {
  title: 'MyDevice',
  component: 'my-device',
  argTypes: {
    backgroundColor: { control: 'color' },
  },
};

interface Story<T> {
  (args: T): TemplateResult;
  args?: Partial<T>;
  argTypes?: Record<string, unknown>;
}

interface ArgTypes {
  title?: string;
  backgroundColor?: string;
}

const Template: Story<ArgTypes> = ({
  title,
  backgroundColor = 'white',
}: ArgTypes) => html`
  <my-device
    style="--my-device-background-color: ${backgroundColor}"
    .title=${title}
  ></my-device>
`;

export const App = Template.bind({});
App.args = {
  title: 'My app',
};
