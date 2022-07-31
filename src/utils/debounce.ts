// https://www.freecodecamp.org/news/javascript-debounce-example/
export function debounce(func: Function, timeout = 300) {
  let timer: number | undefined;
  return (...args: any) => {
    if (!timer) {
      // @ts-expect-error
      func.apply(this, args);
    }
    clearTimeout(timer);
    // @ts-expect-error
    timer = setTimeout(() => {
      timer = undefined;
    }, timeout);
  };
}
