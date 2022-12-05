/**
 * Center component and return
 * @returns {React.CreateElement}
 */
export default function Center({ children, props }) {
  return <div className="flex flex-row items-center justify-center min-h-screen" {...props}>{children}</div>;
}
