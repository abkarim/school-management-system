import CloseButton from "./button/CloseButton";

export default function Notification({ type = "", onClose, closeOnBGClick = false, children, ...props }) {
  let bgClass = "";
  let fgClass = "";

  switch (type) {
    case "warning":
      bgClass = "bg-gradient-to-r from-yellow-300 to-yellow-400"
      break;
    case "error":
      bgClass = "bg-gradient-to-r from-red-600 to-red-700"
      fgClass = "text-white";
      break;
    case "info":
      bgClass = "bg-gradient-to-r from-blue-500 to-blue-600"
      fgClass = "text-white";
      break;
    default:
      bgClass = "bg-gradient-to-l from-green-600 to-emerald-600";
      fgClass = "text-white";
  }

  return (
    <>
      <div className={`fixed inset-0 backdrop-blur-sm z-40 ${closeOnBGClick ? 'cursor-pointer' : ''}`} onClick={closeOnBGClick ? onClose : () => { }}></div>
      <div
        className={`absolute bottom-5 right-5 rounded-md p-2 px-4 shadow-xl max-w-xs lg:max-w-md flex items-center z-50 transition ${bgClass}`}
        {...props}
      >
        <span
          className={`block font-bold font-lato leading-5 tracking-wide text-start ${fgClass}`}
        >
          {children}
        </span>
        <span className="inline-block p-2" onClick={onClose}>
          <CloseButton />
        </span>
      </div>
    </>
  );
}
